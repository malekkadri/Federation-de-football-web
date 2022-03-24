

   function updateComment(x,id1,id2)
        {
            var text = document.getElementById('replyubox'+id2).value;
            $.ajax({
                url: 'updateComment' +  id1+"/"+id2+"/"+text,
                success: function (response) {
                    $('#total').text(response.total);
                }
            });
            fillData(id1);
        }
        function updateCommentr(x,id1,id2)
        {
            var text = document.getElementById('replyboxe'+id2).value;
            $.ajax({

                url: 'updateComment' +  id1+"/"+id2+"/"+text,

                success: function (response) {

                    $('#total').text(response.total);
                }
            });
            fillData(id1);
        }
        function upUComment(x,id1,id2)
        {

            y =   document.getElementById('replyubox'+id2);
            b =   document.getElementById('replyub'+id2);
            if (y.style.display === "none") {
                y.style.display = "block";
                b.style.display = "block";
            } else {
                y.style.display = "none";
                b.style.display = "none";
            }
            //document.getElementById('replybox'+id2).value="deg";

        }
        function editupReply(x,id1,id2)
        {

            y =   document.getElementById('replyboxe'+id2);
            b =   document.getElementById('replybe'+id2);
            if (y.style.display === "none") {
                y.style.display = "block";
                b.style.display = "block";
            } else {
                y.style.display = "none";
                b.style.display = "none";
            }
            //document.getElementById('replybox'+id2).value="deg";

        }
        function upComment(x,id1,id2)
        {

            y =   document.getElementById('replybox'+id2);
            b =   document.getElementById('replyb'+id2);
            if (y.style.display === "none") {
                y.style.display = "block";
                b.style.display = "block";
            } else {
                y.style.display = "none";
                b.style.display = "none";
            }
            //document.getElementById('replybox'+id2).value="deg";

        }
        let fillData = (x) => {
            let ele = document.getElementById('container');
            ele.innerHTML="";
            $.ajax({

                    url: 'listinteractions' + x,



                    success: function (data) {
                        // Change #total text
                        ele.innerHTML =data;

                        // $('#okkk').innerHTML(data);
                        return data;
                    }

                }
            );

        }


        function addComment(x,id1,id2)
        {
            var text = document.getElementById('replybox'+id2).value;
            $.ajax({

                    url: 'addReply' +  id1+"/"+id2+"/"+text,



                    success: function (response) {
                        // Change #total text
                        $('#total').text(response.total);
                    }
                }
            );
            fillData(id1);
        }
        function addCommentm(x,id1)
        {
            var text = document.getElementById('commentbox'+id1).value;
            $.ajax({

                    url: 'addComment' +  id1+"/"+text,

                    success: function (response) {
                        // Change #total text
                        $('#total').text(response.total);
                    }
                }
            );
            fillData(id1);
        }
        function deleteReply(x,id1,id2)
        {

            $.ajax({

                    url: 'delComment' +  id1+"/"+id2,



                    success: function (response) {
                        // Change #total text
                        $('#total').text(response.total);
                    }
                }
            );

            document.getElementById("devs"+id2).style.display="none";
           // document.getElementById("collapse"+id2).style.display="none";
        }
        function deleteComment(x,id1,id2)
        {
            $.ajax({

                url: 'delComment' +  id1+"/"+id2,



                success: function (response) {
                    // Change #total text
                    $('#total').text(response.total);
                }
            }
            );
            document.getElementById("heading"+id2).style.display="none";
            document.getElementById("collapse"+id2).style.display="none";
        }
        function myFunction(x) {


                        if($('#btnAddProduct').hasClass("fa fa-thumbs-up u")){


                            $('#btnAddProduct').removeClass("fa fa-thumbs-up u")
                            $('#btnAddProduct').addClass("fa fa-thumbs-up y");
                            document.getElementById('btnAddProduct').style.color='#1E90FF';
                            $.ajax({

                                url: 'addL' +  document.getElementById('btnAddProduct').getAttribute('data-id'),


                                success: function (response) {
                                    // Change #total text
                                    $('#total').text(response.total);
                                }
                            });


            }
                        else
                        {


                            $('#btnAddProduct').removeClass("fa fa-thumbs-up y")
                            $('#btnAddProduct').addClass("fa fa-thumbs-up u");
                            document.getElementById('btnAddProduct').style.color='#606060';
                            $.ajax({

                                url: 'removeL' + document.getElementById('btnAddProduct').getAttribute('data-id'),


                                success: function (response) {

                                    $('#total').text(response.total);
                                }
                            });

                        }

        }
   function myFunctiond(x) {


           let ele = document.getElementById('containerar');
           ele.innerHTML="";
           $.ajax({

               url: 'triRD',


               success: function (response) {
                   ele.innerHTML=response;
                   // Change #total text
                   $('#total').text(response.total);
               }
           });



   }
   function myFunctiona(x) {


       let ele = document.getElementById('containerar');
       ele.innerHTML="";
       $.ajax({

           url: 'triRA',


           success: function (response) {
               ele.innerHTML=response;
               // Change #total text
               $('#total').text(response.total);
           }
       });



   }
   function myFunctiondn(x) {


       let ele = document.getElementById('containerar');
       ele.innerHTML="";
       $.ajax({

           url: 'triRDN',


           success: function (response) {
               ele.innerHTML=response;
               // Change #total text
               $('#total').text(response.total);
           }
       });



   }
   function myFunctionan(x) {


       let ele = document.getElementById('containerar');
       ele.innerHTML="";
       $.ajax({

           url: 'triRAN',


           success: function (response) {
               ele.innerHTML=response;
               // Change #total text
               $('#total').text(response.total);
           }
       });



   }