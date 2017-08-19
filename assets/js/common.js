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
