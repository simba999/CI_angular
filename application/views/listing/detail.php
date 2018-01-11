<style type="text/css">
.lSSlideOuter.vertical .lSGallery {
    right: auto;
    left: 0;
}
</style>
<div class="mainBodyPart">

<section class="titleSection">
	<div class="widget">
		<div class="widget-body">
			<div class="row">
				<div class="col-md-6">
					<h2><strong><?php  echo $listdetail->AddressFull; ?></strong></h2>
					<h5 class="colorFortitleTextMainColor"><?php  echo $listdetail->AddressCity.'  '.$listdetail->AddressState.' '.$listdetail->AddressCountry.'  '.$listdetail->AddressPostalCode; ?></h5>
				</div>
				<div class="col-md-1">
					<h4 class="MainTitleSectionCenter"><strong><?php echo $listdetail->PropertyBedRooms ?></strong></h4>
					<h5 class="colorFortitleText">Beds</h5>
				</div>
				<div class="col-md-1">
					<h4 class="MainTitleSectionCenter"><strong><?php echo $listdetail->PropertyBathrooms ?></strong></h4>
					<h5 class="colorFortitleText">Baths</h5>
				</div>
				<div class="col-md-1">
					<h4 class="MainTitleSectionCenter"><strong><?php echo $listdetail->PropertyArea ?></strong></h4>
					<h5 class="colorFortitleText">Sq Ft</h5>
				</div>
				<div class="col-md-3">
					<h4 class="MainTitleSectionCenter"><strong>LP: 
						<?php 
						/* $agent = $listdetail->Agent[0]; 
						echo $agent->AgentFirstName.' '.$agent->AgentLastName; */
						 echo '$ '.number_format($listdetail->ListPrice,2);
						?>
							
						</strong></h4>
					<h5 class="colorFortitleText"><?php echo $listdetail->PropertySubType; ?></h5>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="singleProperty">
	<div class="widget">
		<div class="widget-body">
				<div class="row">
					<div class="col-sm-12 col-md-8">
						<?php if(!empty($listdetail->ImageUrl)){
							$largeImage = $listdetail->ImageUrl[0];
							$images = $listdetail->ImageUrl;
						 ?>
						<ul id="image-gallery" class="gallery list-unstyled cS-hidden">
							<?php foreach ($images as $image) { ?>
							<li data-thumb="<?php echo $image->ImageUrl; ?>"> 
		                        <img src="<?php echo $image->ImageUrl; ?>" />
		                    </li>
		                    <?php } ?>
						</ul>
						<?php } ?>
					</div>
					<div class="col-sm-12 col-md-4">
						<?php 
							$GeoLat = $listdetail->GeoLat;
							$GeoLng = $listdetail->GeoLng;
							if($GeoLat!='' && $GeoLng !=''){
						?>
						<div class="row">
							<iframe class="googleMapProp" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $GeoLat; ?>,<?php echo $GeoLng; ?>&amp;key=AIzaSyAiKRex3MGUxBHSqK2uIRcY3sXD5kBdxrM" height="480px" width="100%" allowfullscreen></iframe>
						</div>
						<?php }else{?>
						<div class="row text-center">
							<h4>Location not found</h4>
						</div>
						<?php } ?>
					</div>
				</div>
				<br>
				<br>
				<div class="row">
					<div class="col-sm-12 col-md-4 border-left-widget">
						<!--<div class="row">
							<div class="col-md-12 text-right">
								<span class="editInfoListing"><i class="fa fa-pencil"></i></span>
							</div>
						</div>-->
						<div class="row">
							<div class="col-md-6">
								<span>Listing Agent</span>
							</div>
							<div class="col-md-6">
								<span><strong><?php 
								$agent = $listdetail->Agent[0];
								 echo $agent->AgentFirstName.' '.$agent->AgentLastName; ?></strong></span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<span>Building/Living Area (Sq. Ft.)</span>
							</div>
							<div class="col-md-6">
								<span><strong><?php echo $listdetail->PropertyArea ?></strong></span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<span>Lot Size (Sq. Ft.)</span>
							</div>
							<div class="col-md-6">
								<span><strong><?php echo $listdetail->PropertyLotSize ?></strong></span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<span>Price per Sq. Ft.</span>
							</div>
							<div class="col-md-6">
								<span><strong>$ 2,500</strong></span>
							</div>
						</div>
					</div>

					<div class="col-sm-12 col-md-8">
							<div class="row alignRemark">
								<!--<div class="col-md-12 text-right">
									<span class="editInfo"><i class="fa fa-pencil"></i></span>
								</div>-->
								<div class="col-md-12">
									<div>
										<h5>Remarks:</h5>
									</div>
								</div>
								<div class="col-md-12">
									<h5 class="colorFortitleTextMainColor">
										<?php echo $listdetail->Remarks; ?>
									</h5>
								</div>
							</div>
					</div>
				</div>
		</div>
	</div>
</section>

<section class="generalInfo">
	<div class="widget">
		<div class="widget-body">
			<div class="row">
				<div class="col-sm-12 col-md-2 border-left-widget">
					<div class="row">
				    	<div class="col-md-12">
				   			<h4>
				   				<span><strong> Structure Info </strong></span>
				   				<!--<span class="editInfo"><i class="fa fa-pencil"></i></span> -->
				   			</h4>
				    	</div>
				    	<div class="col-md-12">
				    			<div class="row">
				    				<div class="col-md-6">Year Built</div>
				    				<div class="col-md-6">
				    					<span><strong><?php echo $listdetail->PropertyYearBuilt; ?></strong></span>
				    				</div>
				    			</div>
				    			<div class="row">
				    				<div class="col-md-6">Building # Stories</div>
				    				<div class="col-md-6">
				    					<span><strong><?php echo $listdetail->PropertyStories; ?></strong></span>
				    				</div>
				    			</div>
				    			<div class="row">
				    				<div class="col-md-6">Style</div>
				    				<div class="col-md-6">
				    					<span><strong><?php echo $listdetail->PropertyStyle; ?></strong></span>
				    				</div>
				    			</div>
				    	</div>
				    </div>
				</div>
				<div class="col-sm-12 col-md-3 border-left-widget">
					<div class="row">
				    	<div class="col-md-12">
				    		<h4><span><strong>Land / Parking / Community</strong></span><!--<span class="editInfo"><i class="fa fa-pencil"></i></span> --></h4>
				    	</div>
				    	<div class="col-md-12">
				    		<div class="row">
			    				<div class="col-md-6">Horse Property</div>
			    				<div class="col-md-6"><span><strong>No</strong></span></div>
			    			
								<div class="col-md-6">Total Parking Spaces</div>
								<div class="col-md-6">
									<span><strong><?php echo $listdetail->PropertyParkingSpaces; ?></strong></span>
								</div>
								<div class="col-md-6">School District</div>
								<div class="col-md-6">
									<span><strong><?php echo $listdetail->SchoolDistrict; ?></strong></span>
								</div>
								<div class="col-md-6">Elementry School</div>
								<div class="col-md-6">
									<span><strong><?php echo $listdetail->SchoolElementarySchool; ?></strong></span>
								</div>
								<div class="col-md-6">Junior High School</div>
								<div class="col-md-6"><span><strong><?php echo $listdetail->SchoolMiddleSchool; ?></strong></span>
								</div>
								<div class="col-md-6">High School</div>
								<div class="col-md-6">
									<span><strong><?php echo $listdetail->SchoolHighSchool; ?></strong></span>
								</div>
				    		</div>
				    	</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-3 border-left-widget">
					<div class="row">
				    	<div class="col-md-12">
				    		<h4><span><strong>Contact Info</strong></span><!--<span class="editInfo"><i class="fa fa-pencil"></i></span>--></h4>
				    	</div>
				    	<div class="col-md-12">
				    		<div class="row">
				    			<div class="col-md-6">Listing Date</div>
				    			<div class="col-md-6"><span><strong><?php echo date("d/m/y",strtotime($listdetail->ListDate)); ?></strong></span></div>
								<div class="col-md-6"> Listing Price</div>
								<div class="col-md-6"><span><strong><?php echo $listdetail->ListPrice ?></strong></span></div>
								<div class="col-md-6">Original List Price</div>
								<div class="col-md-6"><span><strong><?php echo $listdetail->ListPrice ?></strong></span></div>
								<div class="col-md-6">Change Date / Type</div>
								<div class="col-md-6"><span><strong>Contact Agent</strong></span></div>
								<div class="col-md-6">CSO</div>
								<div class="col-md-6"><span></span></div>
								<div class="col-md-6">Listing Type</div>
								<div class="col-md-6"><span><strong><?php echo $listdetail->PropertySubType ?></strong></span></div>
				    		</div>
				    	</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-2 border-left-widget">
					<div class="row">
				    	<div  class="col-md-12">
				    		<h4><span><strong>Interior Features</strong></span><!--<span class="editInfo"><i class="fa fa-pencil"></i></span>--></h4>
				    	</div>
				    	<div class="col-md-12">
				    		<div class="row">
				    			<div class="col-md-6">Equipment / Appliances</div><div class="col-md-6"></div>
				    			<div class="col-md-6">AC / Cooling</div>
				    			<div class="col-md-6"><span><strong><?php echo $listdetail->PropertyCooling; ?></strong></span></div>
				    			<div class="col-md-6">Heating</div>
				    			<div class="col-md-6"><span><strong><?php echo $listdetail->PropertyHeating; ?></strong></span></div>
				    			<div class="col-md-6">Fireplaces</div>
				    			<div class="col-md-6"><span><strong><?php echo $listdetail->PropertyFirePlaces; ?></strong></span></div>
				    			<div class="col-md-6">Rooms</div>
				    			<div class="col-md-6"><span><strong><?php echo $listdetail->PropertyBedRooms; ?></strong></span></div>
				    		</div>
				    	</div>
				    </div>
				</div>
				<div class="col-sm-12 col-md-2">
					<div class="row">
				    	<div class="col-md-12">
				    		<h4><span><strong>Exterior Features</strong></span><!--<span class="editInfo"><i class="fa fa-pencil"></i></span>--></h4>
				    	</div>
				    	<div class="col-md-12">
				    		<div class="row">
				    			<div class="col-md-6">Spa</div><div class="col-md-6">-</div>
				    			<div class="col-md-6">Pool</div>
				    			<div class="col-md-6"><span><strong><?php echo $listdetail->PropertyPool; ?></strong></span></div>
				    			<div class="col-md-6">Lundry</div>
				    			<div class="col-md-6"><span><strong><?php echo $listdetail->PropertyLaundryFeatures; ?></strong></span></div>
				    		</div>
				    	</div>
				    </div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="titleSection">
	<div class="widget">
		<div class="widget-body">
			<div class="row">
				<div class="col-md-12"><h2><strong>PROPERTY History</strong></h2><br></div>
			</div>
			<div class="row">
				<div class="col-md-6 border-left-widget">
					<div class="row">
						<div class="col-md-12"><h5><strong>Property Price</strong></h5></div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table style="width:100%" class="property-detail-table">
							  <thead>
								  <tr>
								    <td>Date</td>
								    <td>Events</td> 
								    <td>Price</td>
								    <td>Price/Sq Ft</td>
								    <td>Source</td>
								  </tr>
							  </thead>
							  <tr>
							    <td><?php echo date("m/d/y",strtotime($listdetail->ListDate)); ?></td>
							    <td>Listed</td>
							    <td>$<?php echo $listdetail->ListPrice; ?></td>
							    <td>$<?php echo round($listdetail->ListPrice/$listdetail->PropertyArea); ?></td>
							    <td><?php echo $listdetail->AddressCity; ?></td>
							  </tr>
							  <tr>
							    <td><?php echo date("m/d/y",strtotime($listdetail->ListDate)); ?></td>
							    <td>Sold</td>
							    <td>$<?php echo $listdetail->ListPrice; ?></td>
							    <td>$<?php echo round($listdetail->ListPrice/$listdetail->PropertyArea); ?></td>
							    <td></td>
							  </tr>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12"><h5><strong>Property Price</strong></h5></div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table style="width:100%; text-align: center" class="property-detail-table">
							  	<thead>
									<tr>
										<td>Year</td>
										<td>Taxes</td> 
										<td>Land</td>
										<td></td>
										<td>Additions</td>
										<td></td>
										<td>Total Assessment</td>
									</tr>
								</thead>
							  
							  <tr>
							    <td><?php echo $listdetail->PropertyYearBuilt; ?></td>
							    <td><?php echo $listdetail->TaxTaxAnnualAmount!='' ? 'N/A': $listdetail->TaxTaxAnnualAmount; ?></td>
							    <td>$<?php echo $listdetail->ListPrice; ?></td>
							    <td>+</td>
							    <td>$<?php echo $listdetail->ListPrice; ?></td>
							    <td>=</td>
							    <td>$<?php echo $listdetail->ListPrice; ?></td>
							  </tr>
							</table>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</section>

<section class="titleSection">
	<div class="widget">
		<div class="widget-body">
			<div class="row">
				<div class="col-md-12">
					<h5>About History & Taxes Data</h5>
					<p class="colorFortitleTextMainColor">The price and tax history data displayed is obtained from public records and/ or MLS feeds from the local jurisdiction. Contact your realtor directly in order to obtain the most up-to-date information available</p>
				</div>
			</div>
		</div>
	</div>
</section>

</div>
<script type="text/javascript">
jQuery(window).load(function() {
            jQuery('#image-gallery').lightSlider({
                gallery:true,
			      item:1,
			      vertical:true,
			      verticalHeight:480,
			      vThumbWidth:150,
			      thumbItem:4,
			      thumbMargin:5,
			      slideMargin:0,

                onSliderLoad: function() {
                    jQuery('#image-gallery').removeClass('cS-hidden');
                }  
            });
		});
</script>