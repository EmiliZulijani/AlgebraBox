@extends('layouts.index')

@section('title', 'AlgebraBox | The greatest cloud storage')

@section('content')


<div class="page-header">
        <div class='btn-toolbar pull-right'>
            <a class="btn btn-primary btn-lg" href="{(route('user.create')}}">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                Upload file
            </a>
        </div>	
        <h1>Files in your storage directory</h1>
</div>
   
   <div class="row">
   
		<div class="col-md-3">.col-md-1</div>
		<div class="col-md-9">.col-md-1</div>
  
  
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
						@foreach($files as $file)
							<tr>
								<td> {{$file}}</td>						
								<td>
									<form>
										<a href="{(route('\'), $file}}" class="btn btn-default">
											<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
											Edit
										</a>
										<a href="{(route('\'), $file}}" class="btn btn-danger action_confirm" data-method="delete" data-token="{{ csrf_token() }}">
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
											Delete
										</a>
									</form>
								</td>
							</tr>
						@endforeach							
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop


