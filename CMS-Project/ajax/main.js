$('form.ajax').on('submit',function(){
    var that = $(this),
        url = that.attr('action'),
        method =that.attr('method'),
        data ={};


    that.find('[name]').each(function () {
        var that =$(this),
            name = that.attr('name'),
            value = that.val();

        data[name] =value;
    });

    $.ajax({
        //action url
        url:url,
        //which type of ajax request
        type:type,
        //data to be processed
        data:data,
        success: function (response) {
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });

    return false;

});
/*
function searchOnKeystroke() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        li[i].style.display = "none";
        if (a.innerHTML.toUpperCase().indexOf(filter) > 0) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";

        }
    }
}
*/

$('#search').keyup(function()
{
    var searchterm = $('#search').val();

    if(searchterm!='')
    {
        $.post('../CMS-Project/config/search.php',{searchterm:searchterm},
            function(data)
            {
                $('#searchresults').html(data);
            });
    }
    else
    {
        $('#searchresults').html('');
    }
});






