<?= $this->Html->css(['daterange.css']) ?>
<div class="container-fluid mt-4">
	<div class="row">
		<div class="col-6">
			<?= $this->Html->image('flats/'.$apartment->image, ['class' => 'img-fluid', 'style' => '']) ?>
		</div>
		<div class="col-6">
			<h5 class="font-weight-bold"><?= $apartment->Topic ?></h5>
			<div class="text-warning p-1">
				<i class="fas fa-star fa-sm"></i>
                <i class="fas fa-star fa-sm"></i>
                <i class="fas fa-star fa-sm"></i>
                <i class="far fa-star fa-sm"></i>
                <i class="far fa-star fa-sm"></i>
                <span class="text-dark" style="font-size: .8rem">3/5 (18)</span>
			</div>
			<div>Vermietet von <?= $this->Html->link($apartment->User->Name, ['controller' => 'users', 'action' => 'view', $apartment->User->UserID], ['class' => 'text-dark font-weight-bold']) ?> in <?= $apartment->Location ?>
			</div>
			<div class="mt-3 pt-2 border-top">
				<h4>Preis ab <kbd class="text-warning">€<?= $apartment->Price ?></kbd> pro Nacht</h4>
			</div>

			<div class="mt-3">
				<span class="text-secondary">Wann wollen Sie einreisen?</span>
				<?= $this->Form->create($apartment, ['action' => 'check']) ?>
				
				<div class="row">
	  				<div class="">
		    			<input id="daterangepicker1" type="hidden">
		    			<div id="daterangepicker1-container" class="embedded-daterangepicker"></div>
	  				</div>
				</div>
				<!-- <script type="text/javascript">
					
					$(function() {
					  $('#daterangepicker1').daterangepicker({
					    opens: 'left'
					  }, function(start, end, label) {
					    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
					  });
					});
				</script> -->
				<?= $this->Form->end(); ?>
			</div>
		</div>
		
	</div>
</div>