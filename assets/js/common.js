function confirmDelete(func) {
  $.confirm({
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
