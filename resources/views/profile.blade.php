<x-layout>

<section id="profile-info" class="bg-light" style="direction: rtl;">
                <div class="container">
                    <div class="main-body">

                          <div class="row gutters-sm">
                            @include('components.profile-sidebar')
                            <div class="col-md-8">
                              <div class="card mb-3">
                                <div class="card-body">
                                  <form action="">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">الاسم كاملا</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="علي حسن">
                                      </div>
                                      <div class="form-group">
                                        <label for="exampleInputEmail1">البريد الاكترومي</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ialyzaafan@gmail.com">
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleInputEmail1">الهاتف</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="01119255735">
                                      </div>

                                      <div class="form-group">
                                        <label for="inputState">العمر</label>
                                <select id="inputState" class="form-control">
									<option>اختر العمر</option>
                                  <option selected>من 18 - الى 25</option>
                                  <option>من 26 الى 35</option>
                                  <option>من 36 الى 45</option>
                                  <option>من 46 الى 60</option>
                                  <option>اكثر من 60</option>
                                </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputState">نوع المستخدم</label>
                                <select id="inputState" class="form-control">
                                  <option selected>بائع</option>
                                  <option>مشتري</option>
                                  <option>بائع و مشتري</option>
                                </select>
                                    </div>

									<div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                <h5>لتغيير كلمه المرور</h5>
                                            </button>
                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
												<div class="form-group">
													<label for="password">ادخل كلمه المرور الحاليه </label>
													<input type="password" class="form-control" id="password" aria-describedby="password" placeholder="***********">
												  </div>
												<div class="form-group">
													<label for="password">ادخل كلمه المرور الجديده </label>
													<input type="password" class="form-control" id="password" aria-describedby="password" placeholder="***********">
												  </div>
												  <div class="form-group">
													<label for="password">اعد ادخال كامه المرور الجديده</label>
													<input type="password" class="form-control" id="password" aria-describedby="password" placeholder="***********">
												  </div>
												  <a href="./forget-pass.html">هل نسيت كلمه المرور ؟</a>
												  </div>
                                        </div>


                                    </div>


                                  </form>
								  <div class="links">

								</div>
                                </div>
                              </div>
							  <a href="" type="button" class="btn btn-primary">حفظ</a>


                            </div>

                          </div>

                        </div>
                    </div>


            </section>

</x-layout>
