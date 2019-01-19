<?= $this->Html->css(['daterange.css']) ?>
<?= $this->Html->script(['jquery.min.js', 'moment.min.js', 'daterange.min.js', 'main.js']) ?>

<?= $this->Form->create($apartment, ['action' => 'show', 'type' => 'post']) ?>
<div class="container-fluid mt-4">
	<div class="row">
		<div class="col-6">
			<?= $this->Html->image('flats/'.$apartment->image, ['class' => 'img-fluid', 'style' => '']) ?>
		</div>
		<div class="col-6">
			<h5 class="font-weight-bold"><?= $apartment->Topic ?></h5>
			<div>Vermietet von <?= $this->Html->link($apartment->User->Name, ['controller' => 'users', 'action' => 'view', $apartment->User->UserID], ['class' => 'text-dark font-weight-bold']) ?> in <?= $apartment->Location ?><i class="ml-2 fas fa-map-marker-alt"></i>
			</div>
			<div class="text-warning p-1">
				<i class="fas fa-star fa-sm"></i>
                <i class="fas fa-star fa-sm"></i>
                <i class="fas fa-star fa-sm"></i>
                <i class="far fa-star fa-sm"></i>
                <i class="far fa-star fa-sm"></i>
                <span class="text-dark" style="font-size: .8rem">3/5 (18)</span>
			</div>
			
			<div class="mt-3 mb-2">
				<kbd class="bg-secondary">Dusche</kbd>
				<kbd class="bg-secondary">Internet</kbd>
				<kbd class="bg-secondary">Balkon</kbd>
				<kbd class="bg-secondary">Aufzug</kbd>
			</div>
			<div class="mt-3 pt-2 border-top">
				<h4>ab <b>€<?= $apartment->Price ?></b> pro Nacht</h4>
			</div>

			<div class="mt-3">
				<span class="text-secondary">Wann wollen Sie einreisen?</span>
				<div class="row">
	  				<div class="container">
		    			<input id="daterangepicker1" type="hidden">
		    			<div id="daterangepicker1-container" class="embedded-daterangepicker"></div>
	  				</div>
				</div>
				<div class="row">
					<div class="col-8">
						<div class="input-group mt-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="">An- und Abreisedatum</span>
							</div>
						  	<input type="text" class="form-control text-center bg-white" name="from" id="from-date" value="<?= empty($data) ? '' : $data['from'] ?>" readonly="">
						  	<input type="text" class="form-control text-center bg-white" name="to" id="to-date" value="<?= empty($data) ? '' : $data['to'] ?>" readonly="">
					  	</div>
					</div>
					<div class="col-4">
<!-- 						<?= $this->Html->control('', ['type' => 'hidden', 'name' => 'UserID', 'value' => 'step1']);?> -->
						<?= $this->Form->submit('Prüfen', [
							'class' => 'btn pl-3 pr-3 mt-3 col-12 text-white float-right', 
							'style' => 'background-color: #e15236', 
							'name' => 'step']
						);?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(!empty($data)): ?>
<div class="container mt-4 mb-4 pt-2 border-top">
	<div class="row">
		<div class="col-12">
			<h3 class="text-center mb-0">
				<?php switch ($data['step']) {
					case 'step1':
						echo "Verfügbarkeit wird geprüft";
						$submitStep = 'step2';
						break;
					case 'step2':
						if(isset($available) && $available == true){
							echo "Preis wird berechnet";
						}else{
							echo "Process hat beendet";
						}
						$submitStep = 'step3';
						break;
					case 'step3':
						echo "Preis wurde berechnet";
						$submitStep = 'end';
						break;
					default:
						$submitStep = 'end';
						echo "Ihre Anfrage wird bearbeitet";
						break;
				}?>
				<?php $accesories_show = $data['step'] == 'step1' || ($data['step'] == 'step2' && isset($available) && $available == true) ?>
				<?php if($accesories_show): ?>
					<div class="lds-ellipsis" style="vertical-align: middle;">
						<div></div>
						<div></div>
						<div></div>
						<div></div>
					</div>
				<?php else: ?>
					<i class="fas fa-check text-success fa-lg" style="text-shadow: 5px 5px 5px #c5efcf"></i>
				<?php endif; ?>
			</h3>
			<h5 class="text-center">
				<?= $this->Form->submit($accesories_show ? 'weiter' : 'fertig', [
					'class' => 'btn-link btn text-info', 
					'name' => $submitStep]
				);?>
			</h5>
		</div>
		<?php if($data['step'] == 'step2' || $data['step'] == 'step3'): ?>
			<div class="col-6 p-3 border-right">
				<?php if(isset($available) && $available == true): ?>
					<span class="d-block">Apartment in Zeitraum von <b><?= $data['from'] ?></b> bis <b><?= $data['to'] ?></b> ist frei<i class="fas fa-check text-success ml-2"></i></span>
				<?php else:?>
					<span class="d-block">Apartment ist in dem Zeitraum ausgebucht<i class="fas fa-times text-danger ml-2"></i></span>
				<?php endif;?>
			</div>
		<?php endif; ?>
		<?php if($data['step'] == 'step3'): ?>
			<div class="col-6 p-3">
				<table class="table">
					<tbody>
						<tr>
							<td class="border-0">2018-01-01</td>
							<td class="border-0">€56</td>
						</tr>
						<tr>
							<td>2018-01-02</td>
							<td>€64</td>
						</tr>
						<tr>
							<td>2018-01-03</td>
							<td>€52</td>
						</tr>
					</tbody>
				</table>
				<div class="text-right">
					<span class="font-weight-bold">Gesamtpreis €162</span>
					<button class="btn btn-warning ml-2">OK</button>
				</div>
				
			</div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>

<?= $this->Form->end(); ?>