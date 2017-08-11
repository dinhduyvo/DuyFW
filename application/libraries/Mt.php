<?php

/**
 * Utility to create table
 *
 * @author vdduy
 */
class Mt {

    private $CI;

    public function __construct() {

        $this->CI =& get_instance();

        $this->CI->load->library('table');

        $template = array(
                'table_open'            => '<table id="tbData" class="table table-bordered table-striped">',

                'thead_open'            => '<thead>',
                'thead_close'           => '</thead>',

                'heading_row_start'     => '<tr>',
                'heading_row_end'       => '</tr>',
                'heading_cell_start'    => '<th>',
                'heading_cell_end'      => '</th>',

                'tbody_open'            => '<tbody>',
                'tbody_close'           => '</tbody>',

                'row_start'             => '<tr>',
                'row_end'               => '</tr>',
                'cell_start'            => '<td>',
                'cell_end'              => '</td>',

                'row_alt_start'         => '<tr>',
                'row_alt_end'           => '</tr>',
                'cell_alt_start'        => '<td>',
                'cell_alt_end'          => '</td>',

                'table_close'           => '</table>'
        );

        $this->CI->table->set_template($template);


    }

	function createNormalTable($columns, $data, $siteurl=null, $editable=TRUE, $deleteable=TRUE, $addable=TRUE, $edittitle = "Sửa", $editcontroller="edit", $editicon="edit", $addurl=""){

	    if($editable){
	        $columns[count($columns)] = $edittitle;
	    }
	    if($deleteable){
	        $columns[count($columns)] = "Xóa";
	    }

	    $this->CI->table->set_heading($columns);

	    foreach ( $data as $row ) {
            $code = $row[count($row)-1];
            unset($row[count($row)-1]);
            if($editable){
                $row[count($row)] = $this->editIcon($siteurl, $code, $editcontroller, $editicon);

            }
            if($deleteable){
                $row[count($row)] = $this->deleteIcon($siteurl, $code);
            }
            $this->CI->table->add_row ( $row);
        }

	    //$this->CI->table->function = 'htmlspecialchars';

	    $html = $this->CI->table->generate();
	    if($addable){
	       $html .= '<table border="0" width="100%">
                                <tr>
                                    <td colspan="8" align="left"><a class="btn btn-info fa fa-plus " href="'.site_url($addurl==""?$siteurl.'/add':$addurl).'"> Thêm mới</a></td>
                                </tr></table>';
	    }
	    return $html;
	}

	function setDataTableJS($tableid) {
	    echo '<script>$("#' . $tableid . '").DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aSorting": [0],
            "language": {
            "sProcessing": "Đang xử lý...",
            "sLengthMenu": "Xem _MENU_ mục",
            "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
            "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
            "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 mục",
            "sInfoFiltered": "(được lọc từ _MAX_ mục)",
            "sInfoPostFix": "",
            "sSearch": "Tìm nhanh:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Đầu",
                "sPrevious": "Trước",
                "sNext": "Tiếp",
                "sLast": "Cuối"
            }}});</script>';
	}

	private function editIcon($siteurl, $code=0, $editcontroller,  $icon='edit'){
	    return '<a href="'.site_url($siteurl.'/'.$editcontroller.'/code/'.$code).'"><i class="fa fa-fw fa-'.$icon.'"></i></a>';
	}
	private function deleteIcon($siteurl, $code=0, $icon='close'){
	    return '<a onclick="return confirmDelete()" href="'.site_url($siteurl.'/delete/code/'.$code).'"><i class="fa fa-fw fa-'.$icon.'"></i></a>';
	}

}
