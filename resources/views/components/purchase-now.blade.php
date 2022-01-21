<div class="text-center mb-3">
                                <?php  if (  App::getLocale()== 'ar' )
    { 
        
        ?>
   
         <a href="{{ url(Config::get('app.locale').'/pricing-seller') }}"><img src="{{ asset('images/1 (1).jpeg') }}" class="img-fluid" /></a>
         
         <?php 
    }
else{  
    
    
    ?>
    
         <a href="{{ url(Config::get('app.locale').'/pricing-seller') }}"><img src="{{ asset('images/1 (1).jpeg') }}" class="img-fluid" /></a>

    <?php
}  
?> 
       

</div>