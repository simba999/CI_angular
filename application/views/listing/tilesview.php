<div class="row">
	<div class="col-sm-12">
		<div class="widget">
			<div class="widget-body">
				<form class="cloud-search" id="searchform">
				  <div class="form-row align-items-center">
					<div class="col-auto">
					  <label class="" for="inlineFormInput">0 Selected</label>									  
					</div>
					<div class="col-7">									  
					  <div class="input-group mb-2 mb-sm-0">
						<div class="input-group-addon"><i class="fa fa-search"></i></div>
						<input type="text" class="form-control" name="search" id="inlineFormInputGroup" placeholder="Search in Results...">
					  </div>
					</div>
					<div class="col-auto">
					  <button class="btn btn-yellow text-uppercase" type="button" id="search">Save Search</button>
					</div>
					<div class="col-auto">
					  <button class="btn btn-yellow text-uppercase btn-y-filter" data-toggle="collapse" data-target="#property-search-filter" aria-expanded="false">Filters</button>
					</div>
					<div class="col-auto tiles-list">
						<div class="btn-group list-view-style" role="group" aria-label="Basic example">
						<a  href="<?php echo base_url(); ?>listing" class="btn btn-default"><i class="fa fa-bars"></i></a>
						<a href="<?php echo base_url(); ?>listing/tilesview"  class="btn  btn-yellow"><i class="fa fa-th-large"></i></a>
						</div>
					</div>
				  </div>
				</form>	
				
				<div class=" collapse" id="property-search-filter" aria-expanded="false">

				<hr/> 
				
				
				<form class="property-search-filter" method="post">
					  <div class="form-row align-items-center">
							<div class="col-auto width-8">									  
							  <input type="text" class="form-control mb-2 mb-sm-0" name="city" id="" placeholder="City">
							</div>
							<div class="col-auto">									  
								<select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="listing_type" id="inlineFormCustomSelect">
									<option selected>All listing Types...</option>
									<option value="1">House</option>
									<option value="2">Condo</option>
									<option value="3">Townhouse</option>
									<option value="4">Multi-family</option>
									<option value="5">Land</option>
									
								</select>
							</div>
							<div class="col-auto width-8">									  
							  <input type="text" name="min_price" class="form-control mb-2 mb-sm-0" id="" placeholder="Min Price">
							</div>
							<div class="col-auto width-8">									  
							  <input type="text" name="max_price" class="form-control mb-2 mb-sm-0" id="" placeholder="Max Price">
							</div>
							<div class="col-auto width-8">									  
							  <input type="text" name="bedrooms" class="form-control mb-2 mb-sm-0" id="" placeholder="Bedrooms">
							</div>
							<div class="col-auto width-8">									  
							  <input type="text" name="bathrooms" class="form-control mb-2 mb-sm-0" id="" placeholder="Bathrooms">
							</div>
							<div class="col-auto width-8">									  
							  <input type="text" name="status" class="form-control mb-2 mb-sm-0" id="" placeholder="Status">
							</div>
							<!--<div class="col-auto">									  
							 <button type="" class="form-control mb-2 mb-sm-0 btn text-uppercase"><i class="fa fa-plus"></i> Properties</button>
							</div>-->
							<div class="col-auto">
							  <button type="button" class="btn btn-yellow btn-p-search filter" id="filter">SEARCH</button>
							</div>
						</div>	
						
					</form>
				</div>
				
				<hr/>
				
				<!--<button type="" class="btn btn-yellow text-uppercase">Add Properties</button>-->
			 </div>
				
		</div>
	</div>
</div>
<div class="property-list">
	<div class="row" id="property-list-table">
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="pagination">
			</div>
		</div>
	</div>
	
</div>
	<?php $this->load->view('components/footer'); ?>

<script type="text/javascript">
function load_data(page)
	 {
		var filter_data = jQuery('form.property-search-filter').serialize();
		var search_data = jQuery('form#searchform').serialize();
	  jQuery.ajax({
	   url:"<?php echo base_url(); ?>listing/getAllListing/"+page,
	   method:"POST",
	   dataType:"json",
	   data: {filter: filter_data,search: search_data},
	   success:function(result)
	   {
	    jQuery('#property-list-table').html('');
	    jQuery('.pagination').html(result.pagination_link);
            jQuery.each(result.listings, function(i, item) {
			var listPrice = parseFloat(result.listings[i].ListPrice);
			var listrow = 
			'<div class="col-sm-4">'+
		
		'<div class="widget">'+
			'<div class="widget-body">'+
				'<div class="row">'+
					'<div class="col-sm-6">'+
						'<a style="background-image:url('+result.listings[i].ImageUrl+')" class="bg-image" href="<?php echo base_url(); ?>listing/propertydetail/'+result.listings[i].Id+'"><div class="favourite"><span style="position:absolute;bottom:0;right:0;font-size:x-large;padding-right: 15%;padding-bottom: 1%;"><i class="fa fa-star" style="color: #ffffff;" aria-hidden="true"></i></span></div></a>'+
					'</div>'+
					
					'<div class="col-sm-6">'+
						'<ul class="pro-detail-tile">'+
							'<li> '+
								'<label> MLS </label>'+
								'<span>'+result.listings[i].MlsId+'</span>'+
							'</li>'+
							'<li> '+
								'<label> Status </label>'+
								'<span>'+result.listings[i].MlsStatusText+'</span>'+
							'</li>'+
							'<li> '+
								'<label> Address </label>'+
								'<span>'+
									result.listings[i].AddressStreetNumberText+' '+result.listings[i].AddressStreetName+
								'</span>'+
							'</li>'+
							'<li> '+
								'<label> City </label>'+
								'<span>'+result.listings[i].AddressCity+'</span>'+
							'</li>'+
							'<li> '+
								'<label> Price </label>'+
								'<span> '+format2(listPrice, "$")+'</span>'+
							'</li>'+
							'<li> '+
								'<label> Bedrooms </label>'+
								'<span>  ' +result.listings[i].PropertyBedRooms+'</span>'+
							'</li>'+
							'<li> '+
								'<label> Bathrooms </label>'+
								'<span>  ' +result.listings[i].PropertyBathrooms+'</span>'+
							'</li>'+
							'<li> '+
								'<label> Sq Ft </label>'+
								'<span>'+result.listings[i].PropertyArea+'</span>'+
							'</li>'+
							'<li> '+
								'<label> Role </label>'+
								'<span>Seller</span>'+
							'</li>'+
						'</ul>'+
						
					'</div>'+
					'<div class="col-sm-12 short-desc-tile">'+
						'<a class="view-desc collapsed pull-right" data-toggle="collapse" href="#propert-desc'+result.listings[i].Id+'"aria-expanded="false" aria-controls="collapseExample">'+
							'<i class="fa fa-chevron-down"></i>'+
						'</a>'+
						'<a class="pull-right" href="javascript:;">'+
							'<i class="fa fa-ellipsis-h"></i>'+
						'</a>'+

						'<div class="collapse short-desc" id="propert-desc'+result.listings[i].Id+'">'+
						  '<h6>Description</h6>'+
							'<p>'+
							result.listings[i].Remarks+
							'</p>'+
						  
						  '<a href="<?php echo base_url(); ?>listing/propertydetail/'+result.listings[i].Id+'">View full description</a>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>'+
	'</div>';
				jQuery('#property-list-table').append(listrow);
		   
		})
	   }
	  
	 });
}
	jQuery(document).ready(function(){
		 load_data('1');
	});

	jQuery(document).on("click", ".pagination li a", function(event){
		event.preventDefault();
		var page = jQuery(this).data("ci-pagination-page");
		load_data(page);
	});
	jQuery(document).on("click", "#filter", function(event){
		event.preventDefault();
		load_data('1');
	});
		jQuery(document).on("click", "#search", function(event){
			event.preventDefault();
			load_data('1');
		});
</script>
