/**
 * Created by mike on 4/16/15.
 */
$('#newUserForm').submit(function(){
    event.preventDefault();

    var that = $(this);
    contents = that.serialize();

    console.log(contents);
    $.ajax({
        url:"/app/php/users.php",
        dataType: "json",
        type:"post",
        data: contents,
        success: function(data){
            console.log(data)
        }
    })

    //return false;
});