<x-layout>
 @section('title')
    الشروط و الاحكام
@endsection

<section style="padding-bottom: 0;">

			<div class="container">

				<div class="card mt3 border-0" style="border-radius: 20px;  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);

                    transition: 0.3s;">

					<div  style="text-align: center; margin:0">

						<img src="{{ asset('/images/policies.jpg') }}" alt="" class="img-fluid w-100" loading="lazy">

 
					</div>

				</div>



			</div>

		</section>

		<section id="terms-cond" class="bg-light">

			<div class="container">

				@foreach ($terms as $term)

					{!! $term->description !!}

				@endforeach

			</div>

		</section>
		
</x-layout>