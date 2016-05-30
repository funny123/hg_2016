<?php
/**********************************
 * Created by PhpStorm
 * User: funny
 * Date: 2016/1/22
 * Time: 18:51
 */
namespace Admin\Model;
class MemberModel extends CommonModel
{
    // 数据表名（不包含表前缀）
    protected $tableName        =   'member';


    public function getLists($map, $size = 15)
    {
        $count = $this->where($map)->count();
        $page = new \Think\Page($count, $size);
        $show = $page->show();
        $limit = $page->firstRow.','.$page->listRows;
        $lists = $this->where($map)->limit($limit)->order('time_x desc')->select();
       // dump(M()->getLastSql());
        return [$lists, $show];

    }
    //导出数据
    /**
     * 导出数据
     * @param $list 导出数据
     * @param $title 表头
     */
    public function exportData($list, $title='')
    {
        import("Org.Util.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        $styleArray1 = array(
            'font' => array(
                'bold' => true,
                'size'=>14,
                'color'=>array(
                    'argb' => '00000000',
                ),
            ),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        $num=1;
        if($title!=''){   //设置标题
            $num=2;
            foreach ($title as $k => $v) {
                $colum=IntToChr($k);
                $objPHPExcel->getActiveSheet()->getStyle($colum.'1')->applyFromArray($styleArray1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum.'1', $v);
                $objPHPExcel->getActiveSheet()->getColumnDimension($colum)->setWidth(24);
            }
        }
        foreach ($list as $k => $v) {
            $v= array_values($v);
            for ($i = 0; $i < count($v); $i++) {
                $colum=IntToChr($i);
                $objPHPExcel->getActiveSheet()->getStyle($colum.($k + $num))->applyFromArray($styleArray1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum.($k + $num),' '.$v[$i]);
                $objPHPExcel->getActiveSheet()->getColumnDimension($colum)->setWidth(24);
            }
        }
        $name = date('Y-m-d H:i:s');
        $objPHPExcel->getActiveSheet()->setTitle('test');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}

