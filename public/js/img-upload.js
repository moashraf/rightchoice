
var images = [];


$('#needsclick').click(function(){

	document.getElementById('image').click();

});



   	  function image_select(img_files) {

    // console.log(img_files);
//var image = document.getElementById('image').files;
    	      		let list = new DataTransfer;



    	  if(img_files.length < 8){



   	  	  for (i = 0; i < img_files.length ; i++) {

          //  alert(image[0].value);


          ///////////////////////////////////////////////////////////////////

                      var size = parseFloat(img_files[i].size / 1024).toFixed(2);

  if(size > 2000){

      alert(size + " بعض الصور لايمكن تحملها بسبب حجمها الكبير جدا ");

  }else{




              	images.push({



								 "name" : img_files[i].name,



								 "url" : URL.createObjectURL(img_files[i]),



								 "file" : img_files[i],



						   });
						     list.items.add(img_files[i])
	  document.getElementById('container-imgs').innerHTML = image_show();



  }


            //console.log(list.items );

           // console.log(list.files);
          document.getElementById('image').files = list.files

        ///////////////////////////////////////////////////////////////////


/*
        if (typeof (img_files[i]) != "undefined") {
            var size = parseFloat(img_files[i].size / 1024).toFixed(2);
            if(size > 3000){

		 list.items.remove(img_files[i])

       document.getElementById('image').files = list.files




            //  console.log( image[i].value );

                alert(size + " بعض الصور لايمكن تحملها بسبب حجمها الكبير جدا ");}
          else{


///////////////////////////////////////////////////////////////////


     //if(list.files.length != 0){    console.log('should work000');}

       //  list.items.remove(2)


      //  console.log(list.files);
       // console.log(list.items);







  ///////////////////////////////////////////////////////////////////

              	images.push({



								 "name" : img_files[i].name,



								 "url" : URL.createObjectURL(img_files[i]),



								 "file" : img_files[i],



						   });




          }
        } else {
            alert("This browser does not support HTML5.");
        }



	*/


			}







            }else{




			    alert("غير مسموح برفع اكثر من 8 صور");



   	  	  for (i = 0; i < img_files.length ; i++) {

          //  alert(image[0].value);
 if (i ===8) { break; }


                    var size = parseFloat(img_files[i].size / 1024).toFixed(2);

  if(size > 2000){

 alert( " الحد الاعلي 2 ميجا  بعض الصور لايمكن تحملها بسبب حجمها الكبير جدا ");

 	  document.getElementById('container-imgs').innerHTML = `
			      <div class="dz-message needsclick">
                                            <br>
                                            <button type="button" class="upBtn"
                                                onclick="document.getElementById('image').click()"> <i
                                                    class="fa fa-upload fa-7x"></i></button>


                                            <p class="mt-3">upload images here</p>
                                        </div>
                                        `;



  }else{

      list.items.add(img_files[i])


              	images.push({



								 "name" : img_files[i].name,



								 "url" : URL.createObjectURL(img_files[i]),



								 "file" : img_files[i],



						   });

						       document.getElementById('container-imgs').innerHTML = image_show();


  }

             document.getElementById('image').files = list.files



       /*
        if (typeof (img_files[i]) != "undefined") {
            var size = parseFloat(img_files[i].size / 1024).toFixed(2);
            if(size > 3000){
                                let list = new DataTransfer;

           for(let ee=0; ee<8; ee++){
             list.items.remove(ee) ;
//console.log(list.files);
        document.getElementById('image').files = list.files


    }


		 list.items.remove(i) ;
//console.log(list.files);
       document.getElementById('image').files = list.files


            //  console.log( image[i].value );

                alert(size + " بعض الصور لايمكن تحملها بسبب حجمها الكبير جدا ");}
          else{
                      let list = new DataTransfer;

                for(let ee=0; ee<8; ee++){
           list.items.add(img_files[ee])
      //  console.log(list.files);
       // console.log(list.items);
        document.getElementById('image').files = list.files


    }


     images.push({



								 "name" : img_files[i].name,



								 "url" : URL.createObjectURL(img_files[i]),



								 "file" : img_files[i],



						   });




          }
        }


        else {
            alert("This browser does not support HTML5.");
        }


	*/



			}



		 /*
		    images=[];
			   document.getElementById('image').value = '';
  			     document.getElementById('image').value = null;

		  document.getElementById('container-imgs').innerHTML = `
			      <div class="dz-message needsclick">
                                            <br>
                                            <button type="button" class="upBtn"
                                                onclick="document.getElementById('image').click()"> <i
                                                    class="fa fa-upload fa-7x"></i></button>


                                            <p class="mt-3">upload images here</p>
                                        </div>
                                        `;
                                        */


			}







   	  }

   	  function image_show() {



   	  	  var image = "";

          var mainNow = 0 ;

   	  	  images.forEach((i) => {



   	  	  	 image += `<ul style="padding:10px !important;">

   	  	  	 <li>

   	  	  	 <div style="border:solid black 2px;" class="image_container d-flex justify-content-center position-relative">



   	  	  	  	  <img src="`+ i.url +`" alt="Image">



   	  	  	  	  <span class="position-absolute" onclick="delete_image(`+ images.indexOf(i) +`)">&times;</span>



   	  	  	  </div> </li>

   	  	  	 <li><button class="btn btn-primary" type="button" onclick="mackmainimgjs(`+ images.indexOf(i) +`)">
   	  	  	 اجعلها رئيسيه
   	  	  	 </button></li>



   	  	  	 </ul>`;



   	  	  })



   	  	  return image;



   	  }

   	  function delete_image(e) {



   	  	  images.splice(e, 1);

         if(images.length < 1){


              document.getElementById('container-imgs').innerHTML = `
			      <div class="dz-message needsclick">
                                            <br>
                                            <button type="button" class="upBtn"
                                                onclick="document.getElementById('image').click()"> <i
                                                    class="fa fa-upload fa-7x"></i></button>


                                            <p class="mt-3">upload images here</p>
                                        </div>
                                        `;
                               document.getElementById('image').value = '';

         }else{
        document.getElementById('container-imgs').innerHTML = image_show();

         }





   	  }

 	  function mackmainimgjs(numofimg) {

 	     // alert(numofimg);

 	      document.getElementById('mainImg').value = numofimg;
 	  }


   	  function check_duplicate(name) {



   	  	var image = true;



   	  	if (images.length > 0) {



   	  		for (e = 0; e < images.length; e++) {



   	  			if (images[e].name == name) {



   	  				image = false;



   	  				break;



   	  			}



   	  		}



   	  	}



   	  	return image;



   	  }
