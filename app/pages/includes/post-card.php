
<div class="col-md-6">
    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary"><?=esc($row['category'] ?? 'Unknown')?></strong>
            <a href="<?=ROOT?>/post/<?=$row['slug']?>"></a>
            <h3 class="mb-0"><?=esc($row['title'])?></h3>
            <div class="mb-1 text-muted">Nov 12</div>
            <div class="mb-1 text-muted"><?=date("jS M, Y",strtotime($row['date']))?></div>
            <a href="<?=ROOT?>/post/<?=$row['slug']?>" class="stretched-link">Continue reading..</a>
        </div>
        <div class="col-auto d-none d-lg-block">
            <a href="<?=ROOT?>/post/<?=$row['slug']?>">
                <img class="bd-placeholder-img w-100" width="200" height="250" style="object-fit:cover;" src="<?=get_image($row['image'])?>">
            </a>
        </div>
    </div>
</div>