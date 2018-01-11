<div class="modal snooze" id="contact-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" id="add-25-contacts">
        <div class="modal-content">
            <form method="post" action="<?php echo  base_url(); ?>dashboard/addContactToCircel">
            <div class="modal-header">
               <h4 class="modal-title" id="myModalLabel">Add 25 Contact to circles</h4>
			   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </div>
            <?php 
            	if($this->session->flashdata('addContactSuccessfully')){
            		?>
            <div class="modal-body">
                <div class="container">
                	
                	
                    <div class="row">
						<div class="col-sm-12 text-center">
							<img class="center-block img-responsive" src="<?php echo base_url() ?>assets/global/images/successImport.png" />							
						</div>
                    </div>
					
					<div class="row">
						<div class="col-sm-12 text-center">
							<h5 class="text-uppercase">success!</h5>
							<p>Thank you for taking time to complete <br/> and submit the requirements.</p>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 text-center">
							<a  class="btn btn-yellow" href="<?php echo base_url();?>dashboard">Back to Dashboard</a>
						</div>
					</div>
				</div>
			</div>
					<?php }else{ ?>
			<div class="modal-body">
                <div class="container">	
					<div class="row">
						<div class="col-sm-12">
								<?php for($i=1;$i<=25;$i++){ ?>
								<div class="row">
									<div class="col-md-6">
										<strong>Add Contact Name <?php echo $i; ?></strong>
										<div class="form-group" >
											<input type="text" name="contact_name[]" class="form-control" required value="">
										</div>
									</div>
									<div class="col-md-6">
										<label>&nbsp;</label>
										<div class="form-group" >
											<select name="circle[]" class="form-control selectCircle" required>
												<option value="">Select Circle</option>
												<?php foreach($circles as $circle){
													echo "<option value='".$circle->Id."' color='".$circle->Color."'>";
													echo $circle->Name;
													echo "</option>";
												} ?>
											</select>
										</div>
									</div>
								</div>
								<?php } ?>
								
							
						</div>
                    </div>

                   

                </div>


            </div>
            <div class="modal-footer">
            		<div class="add-25-contacts">
								<button type="submit" class="btn btn-yellow">Add</button>
								<button type="button" class="btn btn-yellow-outline" class="close" data-dismiss="modal" aria-label="Close">Cancel</button>
							</div>
            </div>
             <?php } ?>
            
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
setTimeout(function(){
	$('.selectCircle').each(function(){
    var $this = $(this), numberOfOptions = $(this).children('option').length;
	$this.addClass('select-hidden'); 
    $this.wrap('<div class="select newSelect"></div>');
    $this.after('<div class="select-styled"></div>');
	var $styledSelect = $this.next('div.select-styled');
    $styledSelect.text($this.children('option').eq(0).text());
  
    var $list = $('<ul />', {
        'class': 'select-options'
    }).insertAfter($styledSelect);
  
    for (var i = 0; i < numberOfOptions; i++) {
		$($list).append('<li  rel="'+$this.children('option').eq(i).val()+'" color="'+$this.children('option').eq(i).attr('color')+'"><i class="fa fa-circle fa-2x" style="color:'+$this.children('option').eq(i).attr('color')+'"></i>'+"<span>"+$this.children('option').eq(i).text()+"</span>"+'</li>');
		
	}
   var $listItems = $list.children('li');
   $styledSelect.click(function(e) {
        e.stopPropagation();
        $('div.select-styled.active').not(this).each(function(){
            $(this).removeClass('active').next('ul.select-options').hide();
        });
        $(this).toggleClass('active').next('ul.select-options').toggle();
    });
    $listItems.click(function(e) {
        e.stopPropagation();
        $styledSelect.text($(this).text()).removeClass('active');
		
		$styledSelect.attr('class','');
		$styledSelect.addClass('select-styled ');

        $this.val($(this).attr('rel'));
        $styledSelect.prepend('<i class="fa fa-circle fa-2x" style="color:'+$(this).attr('color')+'"></i>');
        $list.hide();
    });
  
    $(document).click(function() {
        $styledSelect.removeClass('active');
        $list.hide();
    });

   


});
 },3000);

  $(window).on("load",function(){	
		$("#contact-add .modal-body").mCustomScrollbar({
			setHeight:500,
			theme:"dark-3"
		});
		
	}); 
</script>