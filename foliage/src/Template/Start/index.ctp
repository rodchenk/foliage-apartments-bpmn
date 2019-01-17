<div class="container-fluid pl-4 pr-4">
   <div class="container-fluid border-bottom pt-3 pb-3 pl-0">
       <button class="btn btn-outline-secondary mr-2" style="font-size: .9rem">Datum</button>
       <button class="btn btn-outline-secondary mr-2" style="font-size: .9rem">Gäste</button>
       <button class="btn btn-outline-secondary mr-2" style="font-size: .9rem">Unterkunft</button>
       <button class="btn btn-outline-secondary mr-2" style="font-size: .9rem">Preis</button>
       <button class="btn btn-outline-secondary mr-2" style="font-size: .9rem">Weitere Filter</button>
   </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-9 row mx-auto">
            <?php foreach($apartments as $apartment): ?>
                <div class="col-4 mb-3 mt-2">
                    <div class="" style="min-height: 200px;">
                        <div class="" style="max-height: 220px;overflow:hidden">
                            <?= $this->Html->image('flats/'.$apartment->image, ['class' => 'img-fluid img-special']); ?>
                        </div>
                        <div class="p-1 pt-2 mb-0 text-secondary" style="font-size: .8rem">
                            <kbd class="bg-light text-dark border mr-2">plus</kbd>
                            Verifiziert • Gesamtwohnung • <span class="font-weight-bold"><?= $apartment->Location ?></span>
                        </div>
                        <h6 class="font-weight-bold p-1 mb-0">
                            <?= $this->Html->link($apartment->Topic, ['controller' => 'Apartments', 'action' => 'Show', $apartment->ApartmentID], ['class' => 'text-dark']) ?>
                        </h6>
                        <div class="p-1">
                            ab <b>€<?= $apartment->Price?></b> pro Nacht
                        </div>
                        <div class="text-warning p-1">
                            <i class="fas fa-star fa-sm"></i>
                            <i class="fas fa-star fa-sm"></i>
                            <i class="fas fa-star fa-sm"></i>
                            <i class="far fa-star fa-sm"></i>
                            <i class="far fa-star fa-sm"></i>
                            <span class="text-dark" style="font-size: .8rem">3/5 (18)</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-3 p-2 border-left pr-4">
            <div class="sticky-top" style="top: 10px">
                <div class="input-group mb-1">
                    <input type="text" class="pl-3 border-secondary-light text-dark form-control" placeholder="In Google Maps suchen">
                    <div class="input-group-append">
                        <button class="btn btn-warning pl-3 pr-3" type="button">
                            <i class="fab fa-sistrix"></i>
                        </button>
                    </div>
                </div>
                <?= $this->Html->image('map.png', ['class' => 'img-fluid', 'style' => 'object-fit: cover; height: calc(100vh - 50px)'])?>
            </div>
        </div>
    </div>
</div>