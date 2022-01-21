<x-layout>


<section id="forget-password">
                <div class="form-gap"></div>
<div class="container">
	<div class="row">
        <div class="col-md-4"></div>

		<div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="text-center">
                  <h3><i class="fa fa-lock fa-4x"></i></h3>
                  <h2 class="text-center">نسيت كلمه المرور؟</h2>
                  <p>ادخل البريد الالكتروني او رقم الهاتف</p>
                  <div class="panel-body">
    
                    <form id="forget-form" role="form" autocomplete="off" class="form" method="post">
    
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                          <input id="email" name="email" placeholder="ialyzaafan@gmail.com/0100100000" class="form-control"  type="email">
                        </div>
                      </div>
                      <div class="form-group">
                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="تغير كلمه المرور" type="submit">
                      </div>
                      
                      <input type="hidden" class="hide" name="token" id="token" value=""> 
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4"></div>
	</div>
</div>
            </section>

            <x-adv-slider/>

</x-layout>