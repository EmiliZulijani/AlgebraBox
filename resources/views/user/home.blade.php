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
   
  <div class="col-md-3">
		<div class="list-group">
			<a href="#" class="list-group-item list-group-item-info">Create New Directory</a>
			<a href="#" class="list-group-item list-group-item-info">Upload Files</a>
		</div>
	</div>
	<div class="col-md-9">
		<table class="table table-hover">
			<tr>
				<th>Name</th>
				<th>Action</th>
			</tr>
			
		</table>
	</div>
