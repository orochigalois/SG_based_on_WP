<link href="https://fonts.googleapis.com/css?family=Roboto|Indie+Flower|Kalam|Rock+Salt|Work+Sans:200" rel="stylesheet">
<div class="md-modal">
    <div class="md-content">

        <div class="toolbar">
            <div class="select-style">
                <select id="font-id">

                    <option value="Kalam">Kalam</option>
                    <option value="Indie Flower">Indie Flower</option>
                    <option value="Rock Salt">Rock Salt</option>
                    <option value="Roboto">Roboto</option>
                    <option value="Work Sans">Work Sans</option>
                </select>
            </div>
            <button class="reload-all">Reload Sound/Image</button>
            <button class="game-dictation">Dictation</button>
            <button class="md-close">Close</button>
        </div>


        <div class="vocabulary">
            <h1 data-toggle="modal" data-target="#updateModal"></h1>


            <dl>

            </dl>



        </div>


    </div>
</div>

<div class="md-overlay">

</div>
<div id="image-overlay">
    <img class="prev greyout" src="<?php lp_image_dir(); ?>/prev-arrow.png" alt="prev" />
    <img class="next" src="<?php lp_image_dir(); ?>/next-arrow.png" alt="next" />
</div>

<div id="loadIcon">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
</div>