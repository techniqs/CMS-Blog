
$(document).ready(function(){


    function sortBlogs() {
        var uberBlogs = $(".sortable > div");
        var sortedBlogs = {};
        var prevTopId = 0;
        //console.log(unterBlogs);


        for(var i = 0; i < uberBlogs.length; i++) {
            var unterBlogs = $(uberBlogs[i]).find(".group-item");
            //console.log(unterBlogs);
            var blogId = $(uberBlogs[i]).attr("blogId").toString();
            //console.log(blogId);


            sortedBlogs[i] = {key:blogId,pos:i,children:[]};
            //prevTopId = blogId;
            for(var j = 0; j < unterBlogs.length; j++) {
                var unterBlogId = $(unterBlogs[j]).attr("blogId");
                sortedBlogs[i].children[j]={key:unterBlogId,pos:j};

                //sortedBlogs[prevTopId].push(unterBlogId);
            }
            //console.log(sortedBlogs);

        }

        //console.log(sortedBlogs);



        var array = $.map(sortedBlogs, function(value, index) {
            return [value];
        });

        //console.log(array);



        // for (var arrayIndex in sortedBlogs) {
        //    console.log(arrayIndex);
        //   console.log(sortedBlogs[arrayIndex]);
        //  }

        // myArray = Object.entries(sortedBlogs);

        //console.log(JSON.stringify(sortedBlogs));

        return sortedBlogs;

    }




    // Sort the parents
    $(".sortable").sortable({
        containment: "parent",
        items: ".group-caption",
        tolerance: "pointer",
        cursor: "move",
        handle:".move",
        opacity: 0.7,
        revert: 300,
        delay: 150,
        dropOnEmpty: true,
        placeholder: "movable-placeholder",
        start: function(e, ui) {
            ui.placeholder.height(ui.helper.outerHeight());
        },
        update: function(e, ui) {
            $sortedBlogs=sortBlogs();

/*
            var http = new XMLHttpRequest();
            //Wont do with params
            http.open("POST","http://localhost/CMS-Project/ajax/JsonToDB.php",true);
            //Send the proper header information along with the request
            //DIS FCKN HEADER TRIGGERS ME 2 DEATH
            //NO APPLICATION/JSON WONT WORK FCK U
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            http.onreadystatechange = function() {//Call a function when the state changes.
                if(http.readyState == 4 && http.status == 200) {
                    alert(http.responseText);
                }
            }
            //DOESNT WORK
            //http.send((JSON.stringify($sortedBlogs)));
            //DOESNT WORK
            //http.send((($sortedBlogs)));

            //DOES WORK!?
            //http.send(JSON.stringify({obj:"shitstring"}));


            console.log(JSON.stringify($sortedBlogs));

            http.send((objToString($sortedBlogs)));





*/

            $.ajax({
                //action url
                url:"http://localhost/CMS-Project/ajax/JsonToDB.php",
                //which type of ajax request
                type:"POST",
                //data to be processed
                async:true,
                data:$sortedBlogs,
                success: function (response) {
                    console.log((response));
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });






        }

    });

    // Sort the children
    $(".group-items").sortable({
        containment: "document",
        items: ".group-item",
        connectWith: '.group-items',
        update: function(e, ui) {
            $sortedBlogs=sortBlogs();

/*
            var http = new XMLHttpRequest();
            //Wont do with params
            http.open("POST","http://localhost/CMS-Project/ajax/JsonToDB.php",true);
            //Send the proper header information along with the request


            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = function() {//Call a function when the state changes.
                if(http.readyState == 4 && http.status == 200) {
                    alert(http.responseText);
                }
            }
            //DOESNT WORK
            //http.send((JSON.stringify($sortedBlogs)));
            //DOESNT WORK
            //http.send((($sortedBlogs)));

            //DOES WORK!?
            //http.send(JSON.stringify({obj:"shitstring"}));


            http.send(JSON.stringify($sortedBlogs));

*/


            $.ajax({
                //action url
                url:"http://localhost/CMS-Project/ajax/JsonToDB.php",
                //which type of ajax request
                type:"POST",
                //data to be processed
                async:true,
                data:$sortedBlogs,
                success: function (response) {
                    console.log((response));
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });


        }
    });


    function objToString(obj, ndeep) {
        switch(typeof obj){
            case "string": return '"'+obj+'"';
            case "function": return obj.name || obj.toString();
            case "object":
                var indent = Array(ndeep||1).join('\t'), isArray = Array.isArray(obj);
                return ('{['[+isArray] + Object.keys(obj).map(function(key){
                    return '\n\t' + indent +(isArray?'': key + ': ' )+ objToString(obj[key], (ndeep||1)+1);
                }).join(',') + '\n' + indent + '}]'[+isArray]).replace(/[\s\t\n]+(?=(?:[^\'"]*[\'"][^\'"]*[\'"])*[^\'"]*$)/g,'');
            default: return obj.toString();
        }
    }

});




