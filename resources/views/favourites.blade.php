<x-layout>

<section id="agent-listing">
              <div class="container">
                  <div class="row">

                <div class="col-lg-9">
                         <h3>قائمه المفضلات</h3>
                          <div class="property-list mt-5">
                            <select onchange="sortList();"  class="myselect col-lg-3 mb-3" name="" id="sorting">
                                <option value="">الترتيب</option>
                                <option value="maxPrice">السعر: الاقل اولا</option>
                                <option value="minPrice">السعر: الاعلى اولا</option>
                                <option value="minArea">المساحه: الاقل اولا</option>
                                <option value="maxArea">المساحه: الاعلى اولا</option>
                            </select>

<x-property-card/>

                            </div> 


                </div> 

                </div>
          </section>
			

<x-call-to-action/>

</x-layout>