<?php

class Mu {

    private $CI;

    public function __construct() {

        $this->CI =& get_instance();
    }
    function changeDateTimeFormat($data, $newformat='Y-m-d'){
        $originalDate = $data;
        $newDate = date($newformat, strtotime($originalDate));

        return $newDate;
    }

    function checkValidVNDdate($date){
      $day = (int) substr($date, 0, 2);
      $month = (int) substr($date, 3, 2);
      $year = (int) substr($date, 6, 4);
      return checkdate($month, $day, $year);
    }

    function getUserFromEmail($email){
        $parts = explode("@", $email);
        $username = $parts[0];
        return $username;
    }

    function formatMoney($value){
      return number_format($value, 0, ",", ".");
    }

    function formatNumber($value){
      return number_format($value, 0, ",", ".");
    }

    function getMd5Password($pass){
        return md5($pass.SALT);
    }

    function showVNDate($date){
        return mdate("%d-%m-%Y", strtotime($date));
    }
    function showVNDatetime($date){
        return mdate("%d-%m-%Y %H:%i:%s", strtotime($date));
    }

    function showAvatar($img){
      if($img == ""){
        return "";
      }
      else {
        return base_url().'upload/imgs/'.$img;
      }

    }

    function getGender($value){
        return ($value==1)?"Nam":"Nữ";
    }

    function showStatus($text, $color){
        switch ($color){
            case "red":
                $clsname = "btn-danger";
                break;
            case "orange":
                $clsname = "btn-warning";
                break;
            case "green":
                $clsname = "btn-success";
                break;
            case "blue":
                $clsname = "btn-primary";
                break;
            default:
                $clsname = "btn-default";
        }
        return '<a class="btn '.$clsname.' btn-xs">'.$text.'</a>';
    }

    /*
     * Kiem tra da su dung
     */
    function checkInUsed($tables, $ma){
        foreach ($tables as $table){
            $this->CI->db->select("*");
            $this->CI->db->from($table["name"]);
            $this->CI->db->where($table["code"], $ma);
            $query = $this->CI->db->get();
            if (count ( $query ) > 0) {
                return $query->first_row();
            }
            $this->CI->db->reset_query();
        }
        return null;
    }

    public function increaseViewCount($tableName, $id, $codename="code")
    {
      $data = array('viewcount' => "viewcount+1");
      $this->CI->db->where($codename, $id);
      $this->CI->db->set("viewcount", "viewcount+1", false);
      $this->CI->db->update ( $tableName );
    }

    function getCitiesFromString($citiesString){
      $datas = $this->stringToArray($citiesString);

      $this->CI->db->select("*");
      $this->CI->db->from("mcity");
      $this->CI->db->where_in("code", $datas);
      $query = $this->CI->db->get();
      if (count ( $query ) > 0) {
          return $query->result();
      }
      return [];
    }

    function showCities($citiesString){
      $data = $this->getCitiesFromString($citiesString);
      $output = "";
      $i=1;
      $count = count($data);
      foreach ($data as $item) {
        if($i==$count){
          $output .= $item->name;
        }
        else {
          $output .= $item->name.", ";
        }
        $i++;
      }

      return $output;
    }

    function setSession($name, $value){
        $this->CI->session->set_userdata ( array (
                $name => $value
        ) );
    }

    function getSession($name, $item = NULL) {
      if($this->CI->session->userdata($name)!=null){
        if($item==NULL){
            return $this->CI->session->userdata($name);
        }

        return $this->CI->session->userdata($name)[$item];
      }
      return "";
    }

    /**
     * Lay thong tin nguoi dung luu trong session
     * @param  string $key "key de lay"
     * @return [type]      "gias "
     */
    public function getUserInfo($column=null)
    {
      if($column == null){
        return $this->CI->ion_auth->user()->row();
      }
      else{
        $user = $this->CI->ion_auth->user()->row();
        return $user->$column;
      }
    }

    public function checkDoanhNghiep($userid = null)
    {
      if($userid == null){
        $userid = $this->CI->ion_auth->get_user_id();
      }
      if($this->CI->ion_auth->user()->row()->isdoanhnghiep == 1){
        return true;
      }
      else{
        return false;
      }
    }

    public function getFollow($userid, $for, $forid)
    {
      $this->CI->load->model(array('tfollow'));

      return $this->CI->tfollow->getFollow($userid, $for, $forid);
    }

    function showMessagePage($message, $previous, $next, $type='warning', $previousText="Trở về", $nextText="Đồng ý"){
        $this->setSession("message", array(
                "message" => $message,
                "previous" => $previous,
                "next" => $next,
                "previousText" => $previousText,
                "nextText" => $nextText,
                "type" => $type
        ));
        redirect("home/message");
    }

    public function showDangKyStatus($status)
    {
      $statusText = "";
      switch ($status) {
        case 'APPROVED':
          $statusText = '<a class="btn btn-success btn-xs">Đã xác nhận</a>';
          break;
        case 'NEW':
          $statusText = '<a class="btn btn-primary btn-xs">Đang chờ xác nhận</a>';
          break;
        case 'REJECTED':
          $statusText = '<a class="btn btn-danger btn-xs">Không xác nhận thành công</a>';
          break;
        case 'CANCELLED':
          $statusText = '<a class="btn btn-default btn-xs">Người đăng ký hủy</a>';
          break;

        default:
          $statusText = '<a class="btn btn-warning btn-xs">Chưa đăng ký</a>';
          break;
      }
      return $statusText;
    }

    function createCaptcha(){
        $original_string = array_merge(range(1, 9), range('A', 'Z'));
        $original_string = implode("", $original_string);
        $captcha = substr(str_shuffle($original_string), 0, 6);
        $vals = array(
                'word' => $captcha,
                'img_path' => './captcha/',
                'img_url' => base_url("captcha") . "/",
                'img_width' => '150',
                'img_height' => 30,
                'expiration' => 7200
        );

        $cap = create_captcha($vals);

        $outvalue = $cap['image'];

        if (isset($this->CI->session->userdata['image'])) {
            if (file_exists(BASEPATH . "../captcha/" . $this->CI->session->userdata['image'])) {

                unlink(BASEPATH . "../captcha/" . $this->CI->session->userdata['image']);

                $this->CI->session->set_userdata(array('captcha' => $captcha, 'image' => $cap['time'] . '.jpg'));
            } else {
                if (file_exists(BASEPATH . "../captcha/" . $this->CI->session->userdata['image']))
                    unlink(BASEPATH . "../captcha/" . $this->CI->session->userdata['image']);

                    $this->CI->session->unset_userdata('captcha');
                    $this->CI->session->unset_userdata('image');
            }
        }
        else{
            $this->CI->session->set_userdata(array('captcha' => $captcha, 'image' => $cap['time'] . '.jpg'));
        }

        return $outvalue;
    }

    public function check_login($fromurl, $nexturl="Home", $rolecheck=array("USER")){
      if(!$this->CI->ion_auth->logged_in()) {
          $this->CI->session->set_userdata(array("afterlogin"=>
                                                  array('fromurl' => $fromurl,
                                                        'nexturl' => $nexturl)));
          redirect("auth/login/backto/".$this->encodeUrl($nexturl));
      }
    }

    public function encodeUrl($url)
    {

      $return = $this->CI->encrypt->encode($url);
      $return = strtr($return, array(
                        '+' => '.',
                        '=' => '-',
                        '/' => '~'
                    ));
      return $return;
    }
    public function decodeUrl($url)
    {
      $return = strtr($url, array(
                    '.' => '+',
                    '-' => '=',
                    '~' => '/'
                ));
      $return = $this->CI->encrypt->decode($return);

      return $return;
    }

    public function check_role($rolecheck=array("members")){
      return $this->CI->ion_auth->in_group($rolecheck);
    }

    public function chkEmp($value)
    {
        if (!isset($empty)) {
          return true;
        }
        if($empty=='' || $empty == null){
          return true;
        }
        return false;
    }

    public function do_upload_image($name, $filename=null, $path=FILE_IMAGE_PATH, $filetype=FILE_IMAGE_EXTENTION,
            $max_size = FILE_IMAGE_MAX_SIZE, $max_width = FILE_IMAGE_MAX_WIDTH, $max_height = FILE_IMAGE_MAX_HEIGHT)
    {
        $config['upload_path']          = $path;
        $config['allowed_types']        = $filetype;
        $config['max_size']             = $max_size;
        $config['max_width']            = $max_width;
        $config['max_height']           = $max_height;
        $config['overwrite'] = TRUE;

        if($filename != null){
          if(strlen($filename) <=3){
            $filenamenew =  $this->CI->ion_auth->get_user_id().date('YmdHis').'_'.$filename.'.png';
            $config['file_name'] = $filenamenew;
          }
          else {
            $config['file_name'] = $filename;
          }

        }
        else {
            $filenamenew =  $this->CI->ion_auth->get_user_id().date('YmdHis').'.png';
            $config['file_name'] = $filenamenew;
        }

        $this->CI->load->library('upload', $config);
        $this->CI->upload->initialize($config);

        if ( ! $this->CI->upload->do_upload($name))
        {
            $error = $this->CI->upload->display_errors();

            return array("result" => false, "data" => $error);
        }
        else
        {
            $upload_data = $this->CI->upload->data();

            foreach ($upload_data as $item => $value){
                //$this->addWatermark($value);
                return array("result" => true, "data" => $value);
            }
        }
    }

    public function addWatermark($image, $text="CanthoBox.vn", $type="image")
    {
      $this->CI->load->library('image_lib');
      if($type=="image"){
        $path = FILE_IMAGE_PATH."/".$image;
      }
      $config['source_image'] = $path;
      $config['wm_text'] = $text;
      $config['wm_type'] = 'text';
      $config['wm_font_path'] = './system/fonts/texb.ttf';
      $config['wm_font_size'] = '16';
      $config['wm_font_color'] = 'ffffff';
      $config['wm_vrt_alignment'] = 'center';
      $config['wm_hor_alignment'] = 'center';
      $config['wm_padding'] = '20';

      $this->CI->image_lib->initialize($config);

      $this->CI->image_lib->watermark();
    }
    public function resizeImage($image, $width=null, $height=null, $type="image")
    {
      $this->CI->load->library('image_lib');
      if($type=="image"){
        $path = FILE_IMAGE_PATH."/".$image;
      }
      $vals = @getimagesize($path);
      if(($width!= null && $vals[0] > $width)
        || ($height!= null && $vals[1] > $height)) {
        $config['source_image'] = $path;
        if($width != null){
          $config['width'] = $width;
        }
        if($height != null){
          $config['height'] = $height;
        }

        $this->CI->image_lib->initialize($config);

        $this->CI->image_lib->resize();
      }
    }

    public function check_upload_image($name, $path=FILE_IMAGE_PATH, $filetype=FILE_IMAGE_EXTENTION,
            $max_size = FILE_IMAGE_MAX_SIZE, $max_width = FILE_IMAGE_MAX_WIDTH, $max_height = FILE_IMAGE_MAX_HEIGHT)
    {
        $config['upload_path']          = $path;
        $config['allowed_types']        = $filetype;
        $config['max_size']             = $max_size;
        $config['max_width']            = $max_width;
        $config['max_height']           = $max_height;

        $this->CI->load->library('upload', $config);

        if ( ! $this->CI->upload->check_upload($name))
        {
            $error = $this->CI->upload->display_errors();

            return array("result" => false, "data" => $error);
        }
        else
        {
            return array("result" => true, "data" => "ok");
        }
    }

    public function jsInclude($type){

      switch ($type) {
        case 'fileinput':
          echo '<link rel="stylesheet" href="'.base_url().'assets/js/fileinput/fileinput.min.css">
          <script src="'.base_url().'assets/js/fileinput/fileinput.min.js"></script>';
          break;
        case 'datepicker':
          echo '<link href="'.base_url().'assets/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>
          <script src="'.base_url().'assets/plugins/datepicker/bootstrap-datepicker.js"></script>
          <script src="'.base_url().'assets/plugins/datepicker/locales/bootstrap-datepicker.vi.js"></script>';
          break;
        case 'timepicker':
          echo '<link rel="stylesheet" href="'.base_url().'assets/plugins/timepicker/bootstrap-timepicker.min.css">
          <script src="'.base_url().'assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>';
          break;
        case 'maskmoney':
          echo '<script src="'.base_url().'assets/plugins/mask-money/jquery.maskMoney.js" type="text/javascript"></script>';
          break;
        case 'selectmultiple':
          echo '<link rel="stylesheet" href="'.base_url().'res/plugins/select2/select2.min.css">
                <script src="'.base_url().'assets/plugins/select2/select2.full.min.js"></script>';
          break;
        case 'inputmask':
          echo '<script src="'.base_url().'assets/plugins/input-mask/jquery.inputmask.js"></script>
      		<script src="'.base_url().'assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
      		<script src="'.base_url().'assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>';
          break;
        case 'validation':
          echo '<script src="'.base_url().'assets/plugins/validation/jquery.validate.min.js"></script>
      		<script src="'.base_url().'assets/plugins/validation/localization/messages_vi.js"></script>';
          break;
        case 'ckeditor':
          echo '<script src="'.base_url().'assets/js/ckeditor/ckeditor.js"></script>';
          echo '<script src="'.base_url().'assets/js/ckeditor/config.js"></script>';
          break;
        case 'ckeditorfull':
          echo '<script src="'.base_url().'assets/js/ckeditor/ckeditor.js"></script>
          '.$this->CI->mv->ckeditor_full;
          break;

        default:
          # code...
          break;
      }

    }

    public function jsValidate($formId, $requiredEditors){
      $html = 'var validator = $("#'.$formId.'").validate({
  			ignore: [],
  			rules: {';

        foreach ($requiredEditors as $editor) {
          $html .= '"'.$editor.'": {
              required: true
            },';
        }

  	    $html .= ' },
  			errorElement: "em",
  				errorPlacement: function ( error, element ) {
  					// Add the `help-block` class to the error element
  					error.addClass( "help-block" );

  					if ( element.prop( "type" ) === "checkbox" ) {
  						error.insertAfter( element.parent( "label" ) );
  					} else {
  						error.insertAfter( element );
  					}
  				},
  				highlight: function ( element, errorClass, validClass ) {
  					$( element ).closest(".form-group").addClass( "has-error" ).removeClass( "has-success" );
  				},
  				unhighlight: function (element, errorClass, validClass) {
  					$( element ).closest(".form-group").addClass( "has-success" ).removeClass( "has-error" );
  				}
  		});

  		CKEDITOR.on("instanceReady", function () {
  		    $.each(CKEDITOR.instances, function (instance) {
  		        CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
  		        CKEDITOR.instances[instance].document.on("paste", CK_jQ);
  		        CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
  		        CKEDITOR.instances[instance].document.on("blur", CK_jQ);
  		        CKEDITOR.instances[instance].document.on("change", CK_jQ);
  		    });
  		});

  		function CK_jQ() {
  		    for (instance in CKEDITOR.instances) {
  		        CKEDITOR.instances[instance].updateElement();
  		    }
  				$("#'.$formId.'").valid();
  		}';

      echo $html;
    }

    public function arrayToString($myarray, $separator="|", $fullseparator =false){
      if(!$fullseparator) {
        return implode($separator, $myarray);
      }
      return $separator.implode($separator, $myarray).$separator;
    }
    public function stringToArray($mystr, $separator="|"){
      return explode($separator, $mystr);
    }

    /*
    Format string to url
     */
    public function url_title($str, $separator = '-', $lowercase = FALSE)
  	{
      $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
			'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            '-'=>'\s|\&|\!|\_|\.|\;|-|\(|\)|\+|\?',
            ''=>'(--)|(-$)|\[|\]'
        );

       foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
       }
       return $str;
  	}

    public function getFromArray($datas, $keyvalue)
    {
      foreach ($datas as $key => $value) {
        if($key == $keyvalue){
          return $value["name"];
        }
      }
      return "";
    }

    public function getPromotionPrice($proObj, $price)
    {
      if($proObj->type == "PRICE"){
        return $proObj->value;
      }
      else{
        return round((100-$proObj->percent)*$price/100);
      }
    }

    public function showPromotionPrice($proObj, $price)
    {
      if($proObj->type == "PRICE"){
        return $this->formatMoney($proObj->value);
      }
      else{
        return $this->formatMoney(round((100-$proObj->percent)*$price/100));
      }
    }

    public function showPromotionPrice2($price, $protype, $provalue, $propercent)
    {
      if($protype != ""){
        if($protype == "PRICE"){
          return $this->formatMoney($provalue);
        }
        else{
          return $this->formatMoney(round((100-$propercent)*$price/100));
        }
      }
      else{
        return $this->formatMoney($price);
      }
    }

    public function showPromotionPercent($proObj, $price)
    {
      if($proObj->type == "PRICE"){
        return round(100*$proObj->value/$price,0);
      }
      else{
        return $proObj->percent;
      }
    }

    public function showImage($filename, $dir=null, $width=null)
    {
      if($dir==null){
        $dir = base_url().FILE_IMAGE_URL;
      }
      else {
        $dir = base_url().$dir;
      }
      return '<img class="img-thumbnail img-sm" src="'.$dir.'/'.$filename.'" '.($width!=null?('style="width: '.$width.'px"'):'').'>';
    }

  /**
   * Tim so luong item trong 1 list
   * @param  [type]  $list      [description]
   * @param  [type]  $itemvalue [description]
   * @param  boolean $tuyetdoi  [true: tim chinh xac, false: tim tuong doi]
   * @return [type]             [description]
   */
    public function getCountByItem($list, $itemvalue, $tuyetdoi=true)
    {
      if($tuyetdoi){
        foreach ((array)$list as $item) {
          if($item->item == $itemvalue){
            return $item->count;
          }
        }
      }
      else {
        $numcount = 0;
        foreach ((array)$list as $item) {
          $pos = substr_count ($item->item, $itemvalue);
          //print($item->item.": ".$item->count."-".$pos);
          if($pos >= 1){
            $numcount = $numcount + $item->count;
            //print("X-".$item->item.": ".$pos);
          }
        }
        return $numcount;
      }

      return 0;
    }

    /**
     * Tao button cho nguoi dung follow item
     * @param  [type] $for   [description]
     * @param  [type] $forid [description]
     * @param  string $type  [description]
     * @return [type]        [description]
     */
    public function createFollowButton($for, $forid, $type="ALL")
    {
      if($this->CI->ion_auth->logged_in()) {
        if($this->getFollow($this->getSession("userid"), $for, $forid) == null)  {
          echo '<a class="btn btn-success btn-xs" id="followbutton" onclick="dofollow(\''.site_url("follow/dofollow/forid/".$forid."/type/".$type."/for/".$for).'\', this)"><i class="fa fa-paw margin-r-5"></i><span class="text">Theo dõi</span></a>';
        }
        else {
          echo '<a class="btn btn-success btn-xs" id="followbutton" onclick="dofollow(\''.site_url("follow/dofollow/forid/".$forid."/type/".$type."/for/".$for).'\', this)"><i class="fa fa-paw margin-r-5"></i><span class="text">Đang theo dõi</span></a>';
        }
      }
      else {
        echo '<a class="btn btn-success btn-xs" id="followbutton" data-toggle="modal" data-target="#login-modal"><i class="fa fa-paw margin-r-5"></i><span class="text">Theo dõi</span></a>';
      }
    }

    public function getCurrentDatetime()
    {
      $time = time ();
      $currenttime = mdate ( DATE_INSERT_FORMAT, $time );
      return $currenttime;
    }

    public function createMenuLink($menu)
    {
      if($menu["type"]=="controller"){
        return site_url($menu["link"]);
      }
      elseif($menu["type"]=="static"){
        return site_url('trang/i/'.$menu["link_name"]);
      }
      return site_url('pages/'.$menu['link_name']);
    }

    public function dolog($type1, $id, $type2, $note='') {
        $time = time ();
        $currenttime = mdate ( DATE_INSERT_FORMAT, $time );
        if($type2 == "INSERT"){
          $log = R::dispense('dhistory');
          //$log->createdate = $currenttime;
          $log->createuser = $this->CI->ion_auth->get_user_id();
          $log->note = $note;
          $log->id = $id;
          $log->type = $type1;
          $log->idtmp = $type1.$id;
          R::store($log);
        }
        elseif($type2 == "UPDATE"){
          $log = R::findOne('dhistory','id = ? and type = ?',[$id, $type1]);
          $log->updatedate = $currenttime;
          $log->udateuser = $this->CI->ion_auth->get_user_id();
          $log->note = $note;
          $log->id = $id;
          R::store($log);
        }
    }
}
