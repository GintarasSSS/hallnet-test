<section class="row">
    <div class="col s12">
        <h1>Recent links</h1>
        <?php if($list) : ?>
            <ul class="collection">
                <?php foreach ($list as $item) : ?>
                    <li class="collection-item">
                        <?php $url = $currentUrl . '/' . $item->short_word; ?>
                        <p><a class="url-wrapper" href="<?=$url?>"><?=$url?></a></p>
                        <div><b>Created:</b> <?=\Carbon\Carbon::parse($item->created)->diffForHumans()?></div>
                        <div class="url-wrapper"><?=$item->url?></div>
                        <p>
                            <b>Visited</b>: <?=$item->visited?><br/>
                            <b>Private:</b> <?=$item->private ? 'yes' : 'no'?>
                        </p>
                        <div><?=$item->description?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
