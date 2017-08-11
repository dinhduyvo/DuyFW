<?php
require_once APPPATH.'third_party/rb.php';
/**
 * Utility to create form items
 *
 *
 * @author vdduy
 */
class Mf {

    public function openForm($action, $id="myform"){
        $html = '<form class="form-horizontal" class="cmxform" id="'.$id.'" method="POST" action="'.$action.'" enctype="multipart/form-data">';
        return $html;
    }

    public function closeForm(){
        $html = '</form>';
        return $html;
    }

	public function noteRequire($message = ""){
        $html = '<div class="col-md-12"><font class="text-danger">*</font> ' .($message == ""?'là bắt buộc nhập':$message). '</div> ';
        return $html;
	}

    public function txtIcon($id, $icon, $hint){
    	echo '<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" placeholder="'.$hint.'" class="form-control" id="'.$id.'" name="'.$id.'">
              </div>';
    }

    public function showError($text){
		return '<font class="text-red">'.$text.'</font>';
    }

    public function txtEmail($id, $hint, $width){
    	if(!isset($width)){
    		$width = 12;
    	}
    	echo '<div class="col-sm-'.$width.'">';
    	echo '<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" placeholder="'.$hint.'" class="form-control" id="'.$id.'" name="'.$id.'">
              </div>';
    	echo '</div>';
    }

    public function createSelect($name, $data, $value, $defaultText="...", $isrequired = true) {
        $html = '<select class="form-control" name="' . $name . '" id="' . $name . '" '.($isrequired?"required":"").'>';
        if($defaultText != null) {
            $html .= '<option value="">'.$defaultText.'</option>';
        }
        if ($data != null) {
            foreach ( $data as $item ) {
                if(isset($item->code)){
                    $code = $item->code;
                    $itemname = $item->name;
                }
                else{
                    $code = $item["code"];
                    $itemname = $item["name"];
                }
                if($code == $value){
                    $html .= '<option selected value="' . $code . '">' . $itemname . '</option>';
                }
                else {
                    $html .= '<option value="' . $code . '">' . $itemname . '</option>';
                }
            }
        }

        $html .= '           </select>';
        return $html;
    }

    public function createLabel($id, $value, $label){

        $html = '<div class="form-group '.(form_error($id)!=""?'has-error':'').'">
					<label class="col-sm-3 control-label" for="'.$id.'"><font>&nbsp;</font>'.$label.': </label>
					<div class="col-sm-9" style="margin-top: 7px;"> ';
        $html .= $value;

        $html .= '</div>
				</div>';
        return $html;

    }

    public function createSelectFull($id, $data, $value, $label, $defaultText="...", $isrequired = true, $showerror=true){
        $tmp = $this->createSelect($id, $data, $value, $defaultText, $isrequired);

        $html = '<div class="form-group '.(form_error($id)!=""?'has-error':'').'">
					<label class="col-sm-3 control-label" for="'.$id.'">'.($isrequired?'<font class="text-red">*</font> ':'<font>&nbsp;</font>').$label.': </label>
					<div class="col-sm-9"> ';
        $html .= $tmp;
        if($showerror){
            $html .= $this->showError(form_error($id));
        }
        $html .= '</div>
				</div>';
        return $html;

    }

    public function createManySelectFull($mainlabel, $id, $data, $value, $label, $defaultText="...", $isrequired = true, $showerror=true){
        $count = count($id);
            $isError = false;
            for($i = 0; $i<$count; $i++){
                if(form_error ( $id[$i] ) != ""){
                    $isError = true;
                }
            }
            $html = '<div class="form-group ' . ($isError ? 'has-error' : '') . '">
					<label class="col-sm-3 control-label" for="' . $id[0] . '">' .
            					($isrequired ? '<font class="text-red">*</font> ' : '<font>&nbsp;</font>') . $mainlabel . ': </label>
                    <div class="col-sm-9">';

            $html .= '<div class="row">';

            switch ($count){
                case 2:
                    $width = 6;
                    break;
                case 3:
                    $width = 3;
                    break;
                default:
                    break;
            }

            for($i = 0; $i<$count; $i++){
                $tmp = $this->createSelect($id[$i], $data[$i], $value[$i], $defaultText);

                $html .= '<div class="col-xs-'.$width.'">'.$label[$i].'
                                    '.$tmp.' ';
                if ($showerror[$i]) {
                    $html .= $this->showError ( form_error ( $id[$i] ) );
                }
                $html .= '</div>';
            }

            $html .= '</div>';
        $html .= '</div>
				</div>';
        return $html;

    }

    public function createSelectFullWithLink($mainlabel, $id, $data, $value, $linkdata, $defaultText="...", $isrequired = true, $showerror=true){
        $count = count($id);

            $html = '<div class="form-group ' . (form_error($id) ? 'has-error' : '') . '">
					<label class="col-sm-3 control-label" for="' . $id . '">' .
            					($isrequired ? '<font class="text-red">*</font> ' : '<font>&nbsp;</font>') . $mainlabel . ': </label>
                    <div class="col-sm-9">';

            $html .= '<div class="row">';
            $width = 6;

            $tmp = $this->createSelect($id, $data, $value, $defaultText);

            $html .= '<div class="col-xs-'.$width.'">'.$tmp.' ';
            if ($showerror) {
                $html .= $this->showError ( form_error ( $id ) );
            }
            $html .= '</div>';

            $html .= '<div class="col-xs-'.$width.'">'.$linkdata;
            $html .= '</div>';

            $html .= '</div>';
        $html .= '</div>
				</div>';
        return $html;

    }

    /*
     * Create select with multiple select
     */
    public function createSelectMultiple($name, $data, $values, $height, $isrequired=true) {
        $html = '<select class="form-control select2" multiple="multiple"
                data-placeholder="" style="height:'.$height.'" name="' . $name . '[]" id="' . $name . '"
                        style="width: 100%;
                        '.($isrequired?"required":"").'">';

        if ($data != null) {
            foreach ( $data as $item ) {
                if(is_array($item)){
                  $codevalue = $item["code"];
                  $codename = $item["name"];
                }
                else{
                  $codevalue = $item->code;
                  $codename = $item->name;
                }
                if(is_array($values) && in_array($codevalue, $values)){

                    $html .= '<option selected value="' . $codevalue . '">' . $codename . '</option>';
                }
                else {
                    $html .= '<option value="' . $codevalue . '">' . $codename . '</option>';
                }
            }
        }

        $html .= '           </select>';
        return $html;
    }

    function createSelectMultipleFull($id, $data, $value, $label, $height="100%", $isrequired=true, $showerror = true) {
      $tmp = $this->createSelectMultiple($id, $data, $value, $height, $isrequired);

      $html = '<div class="form-group '.(form_error($id)!=""?'has-error':'').'">
        <label class="col-sm-3 control-label" for="'.$id.'">'.($isrequired?'<font class="text-red">*</font> ':'<font>&nbsp;</font>').$label.': </label>
        <div class="col-sm-9"> ';
      $html .= $tmp;
      if($showerror){
          $html .= $this->showError(form_error($id));
      }
      $html .= '</div>
      </div>';
      return $html;
    }

    /*
     * Create textbox input
     */
    public function createTextBox($id, $value, $label, $isrequired, $showerror =false, $placeholder="", $maxlength=45, $minlength=0, $type="text"){
        $html = '<div class="form-group '.(form_error($id)!=""?'has-error':'').'">
					<label class="col-sm-3 control-label" for="'.$id.'">'.($isrequired?'<font class="text-red">*</font> ':'<font>&nbsp;</font>').$label.': </label>
					<div class="col-sm-9"> ';
        $html .= '<input type="'.$type.'" class="form-control"
                placeholder="'.$placeholder.'"
                id="'.$id.'" name="'.$id.'" maxlength="'.$maxlength.'" minlength="'.$minlength.'"
				value="'.$value.'" '.($isrequired?"required":"").'/> ';
        if($showerror){
            $html .= $this->showError(form_error($id));
        }
        $html .= '</div>
				</div>';
        return $html;
    }

	/*
     * Create textbox input
     */
    public function createHidden($id, $value){
        $html = '<input type="hidden" id="'.$id.'" name="'.$id.'" value="'.$value.'"/> ';
        return $html;
    }

    public function createManyTextBox($mainlabel, $id, $value, $label, $isrequired, $showerror, $placeholder, $icon, $maxlength, $minlength){
        $count = count($id);
            $isError = false;

            for($i = 0; $i<$count; $i++){
                if(form_error ( $id[$i] ) != ""){
                    $isError = true;
                }
            }
            $html = '<div class="form-group ' . ($isError ? 'has-error' : '') . '">
					<label class="col-sm-3 control-label" for="' . $id[0] . '"><font>&nbsp;</font>' .$mainlabel . ': </label>
                    <div class="col-sm-9">';

            $html .= '<div class="row">';

            switch ($count){
                case 2:
                    $width = 6;
                    break;
                case 3:
                    $width = 4;
                    break;
                default:
                    break;
            }

            for($i = 0; $i<$count; $i++){

                $html .= '<div class="col-xs-'.$width.'">'.($isrequired[$i] ? '<font class="text-red">*</font> ' : '<font>&nbsp;</font> ').$label[$i].' <div class="input-group">';
                if($icon[$i] != ''){
                    $html.='<div class="input-group-addon">
                                        <i class="fa fa-'.$icon[$i].'"></i>
                                    </div>';
                }

                $html .= '<input type="text" class="form-control"
                        placeholder="'.$placeholder[$i].'"
                        id="'.$id[$i].'" name="'.$id[$i].'" maxlength="'.$maxlength[$i].'" minlength="'.$minlength[$i].'"
        				value="'.$value[$i].'" '.($isrequired[$i]?"required":"").'/>
                        </div>';
                if ($showerror[$i]) {
                    $html .= $this->showError ( form_error ( $id[$i] ) );
                }
                $html .= '</div>';
            }

            $html .= '</div>';
        $html .= '</div>
				</div>';
        return $html;
    }

    public function createPasswordBox($id, $value, $label, $isrequired, $showerror =false, $placeholder="", $maxlength=45, $minlength=0){
        $html = '<div class="form-group '.(form_error($id)!=""?'has-error':'').'">
					<label class="col-sm-3 control-label" for="'.$id.'">'.($isrequired?'<font class="text-red">*</font> ':'<font>&nbsp;</font>').$label.': </label>
					<div class="col-sm-9"> ';
        $html .= '<input type="password" class="form-control"
                placeholder="'.$placeholder.'"
                id="'.$id.'" name="'.$id.'" maxlength="'.$maxlength.'" minlength="'.$minlength.'"
				value="'.$value.'" '.($isrequired?"required":"").'/> ';
        if($showerror){
            $html .= $this->showError(form_error($id));
        }
        $html .= '</div>
				</div>';
        return $html;
    }

    public function createRadio($mainlabel, $id, $data, $value, $isrequired, $showerror =false){
        $html = '<div class="form-group '.(form_error($id)!=""?'has-error':'').'">
					<label class="col-sm-3 control-label" for="'.$id.'">'.($isrequired?'<font class="text-red">*</font> ':'<font>&nbsp;</font>').$mainlabel.': </label>
					<div class="col-sm-9"> <div class="radio">';

        $i = 0;
        foreach ( $data as $item ) {
            if(isset($item->code)){
                $code = $item->code;
                $itemname = $item->name;
            }
            else{
                $code = $item["code"];
                $itemname = $item["name"];
            }

            $html .= '<label><input type="radio"
                '.($code==$value?'checked':'').'
                id="'.$id.$i.'" name="'.$id.'"
				value="'.$code.'" '.($isrequired?"required":"").'/>'.$itemname.'</label> &nbsp;&nbsp;&nbsp;';
            $i++;
        }

        $html .= '</div>';
        if($showerror){
            $html .= $this->showError(form_error($id));
        }
        $html .= '</div>
				</div>';
        return $html;
    }

    /*
     * Create date picker input
     * Can be multiple
     */
    public function createDatePicker($mainlabel, $id, $value, $label, $isrequired, $showerror =false){


        if (! is_array ( $id )) {
            $html = '<div class="form-group ' . (form_error ( $id ) != "" ? 'has-error' : '') . '">
					<label class="col-sm-3 control-label" for="' . $id[0] . '">' .
            					($isrequired ? '<font class="text-red">*</font> ' : '<font>&nbsp;</font>') . $mainlabel . ': </label>
                    <div class="col-sm-9">';

            $html .= '<div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div><input type="text" class="form-control"
                id="' . $id . '" name="' . $id . '"
				value="' . $value . '" '.($isrequired?"required":"").'/> ';
            if ($showerror) {
                $html .= $this->showError ( form_error ( $id ) );
            }
            $html.='</div>';
            $html .= '<script>$("#'.$id.'").datepicker({
                format: "dd-mm-yyyy",
                language: "vi",
                clearBtn: true
            });</script>';
        }
        else{
            $count = count($id);
            $isError = false;
            for($i = 0; $i<$count; $i++){
                if(form_error ( $id[$i] ) != ""){
                    $isError = true;
                }
            }
            $html = '<div class="form-group ' . ($isError ? 'has-error' : '') . '">
					<label class="col-sm-3 control-label" for="' . $id[0] . '">' .'<font>&nbsp;</font>' . $mainlabel . ': </label>
                    <div class="col-sm-9">';

            $html .= '<div class="row">';

            switch ($count){
                case 2:
                    $width = 6;
                    break;
                case 3:
                    $width = 4;
                    break;
                default:
                    break;
            }

            for($i = 0; $i<$count; $i++){
                $html .= '<div class="col-xs-'.$width.'">'.($isrequired[$i] ? '<font class="text-red">*</font> ' : '<font>&nbsp;</font> ').$label[$i].' <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div><input type="text" class="form-control"
                id="' . $id[$i] . '" name="' . $id[$i] . '"
				value="' . $value[$i] . '" '.($isrequired[$i]?"required":"").'/> </div>';
                if ($showerror[$i]) {
                    $html .= $this->showError ( form_error ( $id[$i] ) );
                }
                $html .= '</div>';
                $html .= '<script>$("#'.$id[$i].'").datepicker({
                    format: "dd-mm-yyyy",
                    language: "vi",
                    clearBtn: true
                });</script>';
            }

            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    /*
     * Create file upload input
     */
    public function createFileUpload($id, $extentions, $label, $isrequired, $maxsize = 0, $showerror =false,  $placeholder="", $value=""){
        $html = '<div class="form-group '.(form_error($id)!=""?'has-error':'').'">
					<label class="col-sm-3 control-label" for="'.$id.'">'.($isrequired?'<font class="text-red">*</font> ':'<font>&nbsp;</font>').$label.': </label>
					<div class="col-sm-9"> '.($value!= ""?'<img src="'.base_url().FILE_IMAGE_URL.'/'.$value.'" class="file-preview-image" height="150px">':'');
        $html .= '<input id="'.$id.'" name="'.$id.'" type="file" class="file"
                data-show-upload="false"
                data-show-caption="true"
                data-allowed-file-extensions=\''.$extentions.'\'
                maxFileSize="1"        >
                <p class="help-block">'.$extentions.'</p>';
        $html .= '<script>$("#'.$id.'").fileinput(';
        if($maxsize > 0){
            $html .= '{
                maxFileSize: '.$maxsize.'
                }';
        }
        $html .= ');</script>';
        if($showerror){
            $html .= $this->showError(form_error($id));
        }
        $html .= '</div>
				</div>';
        return $html;
    }

    /*
     * Create file upload for image
     */
    public function createImageUpload($id, $label, $isrequired = FALSE, $showerror=TRUE, $placeholder="", $value=""){
        return $this->createFileUpload($id, FILE_IMAGE_EXTENTION_JS, $label,
                $isrequired, FILE_IMAGE_MAX_SIZE, $showerror, $placeholder, $value);
    }

    /*
     * Create textarea with wysiwyg
     */
    public function createEditor($id, $value, $label, $isrequired, $showerror =false){
        $html = '<div class="form-group '.(form_error($id)!=""?'has-error':'').'">
					<label class="col-sm-3 control-label" for="'.$id.'">'.($isrequired?'<font class="text-red">*</font> ':'<font>&nbsp;</font>').$label.': </label>
					<div class="col-sm-9"> ';
        $html .= '<textarea id="'.$id.'" name="'.$id.'" '.($isrequired?"required":"").'>'.$value.'</textarea> ';
        if($showerror){
            $html .= $this->showError(form_error($id));
        }
        $html .= '<script>
                  $(function () {
                    CKEDITOR.replace("'.$id.'");
                    //'.($isrequired?'$("#'.$id.'").attr("required","");':"").'
                  });
                </script>';
        $html .= '</div>
				</div>';
        return $html;
    }

    /*
     * create captcha input
     */
    public function createCaptcha($id, $image, $label = "Nhập mã xác nhận", $isrequired = true,
            $showerror = true, $placeholder = "Nhập ký tự theo hình bên cạnh"){
        $html = '<div class="form-group '.(form_error($id)!=""?'has-error':'').'">
					<label class="col-sm-3 control-label" for="'.$id.'">'.($isrequired?'<font class="text-red">*</font> ':'<font>&nbsp;</font>').$label.': </label>';

        $html .= '<div class="col-sm-4">
					<input class="form-control" type="text"
                        placeholder="'.$placeholder.'"
                        id="'.$id.'" name="'.$id.'" '.($isrequired?"required":"").'/>';
        if($showerror){
            $html .= $this->showError(form_error($id));
        }
		$html .=			'</div>
					<div class="col-sm-5">
						'.$image.'
					</div>';


        $html .= '</div>';

        return $html;
    }

    public function createFunctionButtons($buttons)
    {
      $html = '<div class="col-md-12 text-right" style="margin-top: 5px; margin-bottom: 10px;">';
      foreach ($buttons as $btn){
        $html .= '<a id="'.$btn['id'].'" class="btn btn-'.$btn['type'].' btn-circle" href="'.$btn['url'].'">
                <li class="glyphicon glyphicon-'.$btn['icon'].'"></li>
              </a> ';
      }
      return $html.'</div>';
    }

    public function createButtons($type, $previouspage="", $updateText = "Cập nhật", $cancelText = "Bỏ qua"){
        $html = '<div class="form-group"><hr/><div class="col-sm-12">';
		if($type=="back") {
			$html .= '<button class="btn btn-default" type="button" onclick="javascript:window.location.replace(\''.site_url($previous).'\')">'.$cancelText.'</button>';
		}
		elseif($type=="reset"){
			$html .= '<button class="btn btn-default" type="reset">Nhập lại</button>';
		}

		$html .= '<button class="btn btn-info pull-right" type="submit">'.$updateText.'</button></div></div>';

        return $html;
    }

}
