var images = [];



$('#needsclick').click(function(){

	document.getElementById('image').click();

});



   	  function image_select() {



   	  	  var image = document.getElementById('image').files;



   	  	  for (i = 0; i < image.length; i++) {


			
		 
		images.push({
	
	
	
								 "name" : image[i].name,
	
	
	
								 "url" : URL.createObjectURL(image[i]),
	
	
	
								 "file" : image[i],
	
	
	
						   })
	
	
			
	

			}
   	  if(images.length < 10){	

   	  	  document.getElementById('container-imgs').innerHTML = image_show();
}else{
			    
			    alert("Only 10 Images are allowed");
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

   	  	  	 <li><button class="btn btn-primary" type="button" onclick="document.getElementById('mainImg').value = "`+ images.indexOf(i) +`";mainNow=images.indexOf(i);">Main Image</button></li>

			 

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