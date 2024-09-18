@extends('layouts.back')

@section('title','Configuración')
 
@section('main')
		<main>
			<div class="container">
				<div class="row">
					<div class="col s12 miga">
						<p>Configuración</p>
					</div>
					@if(count($errors) > 0)
					<div class="col s12 card-panel red lighten-4 red-text text-darken-4">
						<ul>
							@foreach($errors->all() as $error)
								<li>{!!$error!!}</li>
							@endforeach
						</ul>
					</div>
					@endif

					@if(session('success'))
					<div class="col s12 card-panel green lighten-4 green-text text-darken-4">
						{{ session('success') }}
					</div>
					@endif
				</div>

				<div class="row">
					<div class="col s12">
						<form method="post" action="{{ url('admin/settings') }}">
						@csrf
						@foreach($settings as $setting)
						<div class="row">
							<div class="col s8">
								{{$setting->name}}
							</div>
							<div class="col s4">
								<div class="switch">
									<label>
										No
										<input type="checkbox" name="config[]" value="{{$setting->id}}" @if($setting->value==1) checked @endif>
										<span class="lever"></span>
										Si
									</label>
								</div>
							</div>
						</div>
						@endforeach
						<div class="row">
							<div class="col s12 no-padding">
								<input type="submit" value="Guardar" class="waves-effect waves-light btn right">
							</div>
						</div>
						</form> 
					</div>
				</div>
			</div>
		</main>
@endsection