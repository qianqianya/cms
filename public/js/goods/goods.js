$("#add_cart_btn").click(function(e){
    e.preventDefault();
    var num = $("#goods_num").val();
    var goods_id = $("#goods_id").val();

    $.ajax({
        url     :   '/cartAdd2',
        type    :   'post',
        data    :   {goods_id:goods_id,num:num},
        dataType:   'json',
        success :   function(d){
            if(d.error==301){
                window.location.href=d.url;
            }else{
                alert(d.msg);
                window.location.href='/cartList';
            }
        }
    });
});