angular.module('canthobox.main', []);

function confirmDelete(func) {
  $.confirm({
      theme: 'material',
      title: 'Xác nhận xóa',
      content: 'Bạn có chắc chắn muốn xóa?',
      type: 'blue',
      buttons: {
          ok: {
              text: "Chấp nhận",
              btnClass: 'btn-primary',
              keys: ['enter'],
              action: func
          },
          cancel: {
              text: "Bỏ qua",
              action: function(){
                  }
          }
      }
  });
}
function confirm2(){
  return (confirm("Bạn có chắc?"));
}

function ConvertLinkName(input) {
  output = bodauTiengViet(input);
  output = output.replace(/-/g,' ');
  output = output.replace(/ +/g,' ');
  return output.replace(/ /g,'-');
}

function bodauTiengViet(str) {
        str = str.toLowerCase();
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        return str;
}
$(document).ready(function() {
  $("#ConvertLinkName").click(function(event) {
    $("#link_name").val(ConvertLinkName($("#title").val()));
  });

  $("#ConvertLinkName2").click(function(event) {
    $("#link_name").val(ConvertLinkName($("#name").val()));
  });
});

$(document).on('mouseenter', ".iffyTip", function () {
  var $this = $(this);
  if (this.offsetWidth < this.scrollWidth && !$this.attr('title')) {
      $this.tooltip({
          title: $this.text(),
          placement: "bottom"
      });
      $this.tooltip('show');
  }
});

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
