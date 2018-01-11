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
						<a  href="<?php echo base_url(); ?>listing" class="btn btn-yellow"><i class="fa fa-bars"></i></a>
						<a href="<?php echo base_url(); ?>listing/tilesview"  class="btn btn-default"><i class="fa fa-th-large"></i></a>
						</div>
					</div>
				  </div>
				</form>	
				
				<div class=" collapse" id="property-search-filter" aria-expanded="false">
					<hr/> 
					
					<form class="property-search-filter" method="post">
					  <div class="form-row align-items-center">
							<div class="col-auto width-8 textInCityAddLFilter">									  
							  <input type="text" class="form-control mb-2 mb-sm-0" name="city" id="" placeholder="City">
							</div>
							<div class="col-auto width-8">									  
								<select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="listing_type" id="inlineFormCustomSelect">
									<option selected>All listing types</option>
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
							<!-- <div class="col-auto">									  
							 <button type="" class="form-control mb-2 mb-sm-0 btn text-uppercase"><i class="fa fa-plus"></i> Properties</button>
							</div> -->
							<div class="col-auto PSearchBtnNewAlign">
							  <button type="button" class="btn btn-yellow btn-p-search filter SearchBtnNewAlign" id="filter">SEARCH</button>
							</div>
						</div>	
						
					</form>
				</div>
				
				<!-- <button type="" class="btn btn-yellow text-uppercase BtmMarListIndAddP">Add Properties</button> -->
				<table class="table property-list-hr" id="property-list-table">
					<thead>
						<tr>
							<th>Property</th>											
							<th>MLS</th>
							<th>Status</th>
							<th>Address</th>
							<th>City</th>
							<th>Price</th>
							<th>Bedrooms</th>
							<th>Bathrooms</th>
							<th>Sq. Ft.</th>
							<th>Role</th>
							<th>
								<i class="fa fa-chevron-down"></i>
							</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>							
			 </div>
		</div>
		<div id="curIndex" style="display:none;"><?php echo $curIndex ?></div>
		<div class="pagination">
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
		    jQuery('#property-list-table tbody').html('');
		    jQuery('.pagination').html(result.pagination_link);
	            jQuery.each(result.listings, function(i, item) {
				var listPrice = parseFloat(result.listings[i].ListPrice);
				var listrow = 
					'<tr>'+
						'<td width="9%" style=" position: relative;">'+
							'<div class="favourite"><span style="position:absolute;bottom:0;right:0;font-size:x-large;padding-right: 18%;padding-bottom: 8%;"><i class="fa fa-star" style="color: #ffffff;" aria-hidden="true"></i></span></div><a href="<?php echo base_url(); ?>listing/propertydetail/'+result.listings[i].Id+'"><img class="img-responsive" src="'+result.listings[i].ImageUrl+'" alt=""></a>'+
						'</td>'+
						'<td>'+
							'<span class="">'+result.listings[i].MlsId+'</span>'+
						'</td>'+
						'<td>'+
							'<span class="">'+result.listings[i].MlsStatusText+'</span>'+
						'</td>'+
						'<td>'+
							'<span class="">'+result.listings[i].AddressStreetNumberText+' '+result.listings[i].AddressStreetName+'</span>'+
						'</td>'+
						'<td>'+
							'<span class="">'+result.listings[i].AddressCity+'</span>'+
						'</td>'+
						'<td>'+
							'<span class="">'+format2(listPrice, "$")+'</span>'+
						'</td>'+
						'<td>'+
							'<span class="">'+result.listings[i].PropertyBedRooms+'</span>'+
						'</td>'+
						'<td>'+
							'<span class="">'+result.listings[i].PropertyBathrooms+'</span>'+
						'</td>'+
						'<td>'+
							'<span class="">'+result.listings[i].PropertyArea+'</span>'+
						'</td>'+
						'<td>'+
							'<span class="">Seller</span>'+
						'</td>'+
						'<td>'+
							'<a class="view-desc" data-toggle="collapse" href="#propert-desc'+result.listings[i].Id+'" aria-expanded="false" aria-controls="collapseExample">'+
																'<i class="fa fa-chevron-down"></i>'+
							'</a>'+
						'</td>'+
					'</tr>';
					listrow += '<tr>'+
						'<td colspan="11">'+
							'<div class="collapse short-desc" id="propert-desc'+result.listings[i].Id+'">'+
							  '<h6>Description</h6>'+
								'<p>'+
								result.listings[i].Remarks+
								'</p>'+
							  '<a href="<?php echo base_url(); ?>listing/propertydetail/'+result.listings[i].Id+'">View full description</a>'+
							'</div>'+
						'</td>'+
					'</tr>';
					jQuery('#property-list-table tbody').append(listrow);
			   
			})
		   }
		  
		 });
	}
	jQuery(document).ready(function(){
		var currentPage = jQuery("#curIndex").text();
		 load_data(currentPage);
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
		jQuery(document).on('click','.property-list-hr .view-desc',function(){
			if(jQuery(this).find('.fa').hasClass('fa-chevron-down')){
		  jQuery(this).find('.fa').removeClass('fa-chevron-down').addClass('fa-chevron-up');
		 }else{
		  jQuery(this).find('.fa').removeClass('fa-chevron-up').addClass('fa-chevron-down');
		
		 }
	});
</script>
