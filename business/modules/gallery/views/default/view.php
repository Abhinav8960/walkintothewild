<?php

use common\models\partnergallery\PartnerGallery;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Gallery';

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="galleryViewMain-parent d-flex justify-content-between align-items-center">
                <div class="gallary-title">
                    <p>Gallery View</p>
                </div>
                <div class="selectandsearchmain d-flex align-items-center gap-4">
                    <div class="createGalleryButton-parent d-flex justify-content-center align-items-center">
                        <button value="<?= Url::toRoute(['create-gallery', 'partner_gallery_id' => $partner_gallery_model->id]) ?>" class="galleryCreateAction"><i
                                class="fa-solid fa-plus"></i></button>

                    </div>
                    <div class="d-flex align-items-center gap-4">
                        <!-- <a href="<?= Url::toRoute(['set-sequence', 'partner_gallery_id' => $partner_gallery_model->id]) ?>" class="sequenceBtn">Set sequence</a> -->
                        <a class="button-created new" href="<?= Url::toRoute(['send-for-approval', 'id' => $partner_gallery_model->id]) ?>">Send
                            For Approval</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="details-packages">
                <div class="topHeader d-flex justify-content-between align-items-center px-3 py-3">
                    <div class="date-or-time">
                        <p class="mb-1">Title</p>
                        <p class="mb-0"><?= $partner_gallery_model->title ?></p>
                    </div>
                    <div class="date-or-time">
                        <p class="mb-1">Park</p>
                        <p class="mb-0"><?= isset($partner_gallery_model->park) ? $partner_gallery_model->park->title : '' ?></p>
                    </div>
                    <div class="active-btn">
                        <!-- <a href="">ACTIVE</a> -->
                    </div>
                </div>
                <div class="d-flex">
                    <table class="table w-50 border-0 border_o d-inline-block py-3">
                        <tbody class="tbody-leads sighting-leads py-5 w-100">
                            <tr>
                                <td style="width: 25%;">Created Date:</td>
                                <td style="width: 75%;">
                                    <p><?= date('j F Y, g:i A', $partner_gallery_model->created_at) ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>Updated Date:</td>
                                <td>
                                    <p><?= date('j F Y, g:i A', $partner_gallery_model->updated_at) ?></p>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
       <?php foreach ($dataProvider->getModels() as $index => $model) { ?>
  <div class="col-xxl-3 col-xl-3 col-lg-4 md-6 col-12 mb-3">
    <div class="galleryCard">
      <div class="card p-0 border-0 bg-transparent">
        <div class="position-relative">
          <img 
            src="<?= $model->gallery_image ?>"
            class="card-img-top gallery-image-item" 
            alt=""
            data-index="<?= $index ?>"
          >
          <!-- dropdown menu code stays same -->
        </div>
        <div class="card-body fancy-box-body">
          <p class="mb-2"><?= $model->title ?></p>
          <p><?= $model->caption ?></p>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

    </div>
</div>

<!-- Gallery Slider Modal -->
<div class="modal fade" id="gallerySliderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Gallery View</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="sliderMainImage" src="" class="img-fluid mb-3" alt="Main Image" />
        <div id="sliderThumbnails" class="d-flex flex-wrap justify-content-center gap-2"></div>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"">
    <div class=" modal-content">
        <div class="modal-header headerTitle border-bottom-0 align-items-baseline px-4">
            <p class="" id="">Create Gallery</p>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body px-4 py-4" id='modalContent'>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"">
        <div class=" modal-content">
        <div class="modal-header headerTitle border-bottom-0 align-items-baseline px-4">
            <p class="" id="">Edit Gallery</p>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body px-4 py-4" id='modalContent'>
        </div>
    </div>
</div>
</div>

<script>
    const dropdownWrappers = document.querySelectorAll('.dropdown-wrapper');
    dropdownWrappers.forEach(wrapper => {
        const icon = wrapper.querySelector('.dot-icon');
        icon.addEventListener('click', (e) => {
            e.preventDefault();
            dropdownWrappers.forEach(w => {
                if (w !== wrapper) {
                    w.classList.remove('open');
                }
            });
            wrapper.classList.toggle('open');
        });
    });
    document.addEventListener('click', (e) => {
        dropdownWrappers.forEach(wrapper => {
            if (!wrapper.contains(e.target)) {
                wrapper.classList.remove('open');
            }
        });
    });
</script>

<?php
$script = <<< JS


    $('.galleryCreateAction').on('click', function () {
        $('#exampleModal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

      $('.galleryEditAction').on('click', function () {
        $('#editModal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

// Your existing modal create/edit JS...

$('.galleryCreateAction').on('click', function () {
  $('#exampleModal').modal('show')
    .find('#modalContent')
    .load($(this).attr('value'));
});

$('.galleryEditAction').on('click', function () {
  $('#editModal').modal('show')
    .find('#modalContent')
    .load($(this).attr('value'));
});

// Gallery slider logic
const galleryImages = [];
document.querySelectorAll('.gallery-image-item').forEach(img => {
  galleryImages.push(img.src);
});

document.querySelectorAll('.gallery-image-item').forEach((img, index) => {
  img.addEventListener('click', () => {
    const sliderModal = new bootstrap.Modal(document.getElementById('gallerySliderModal'));
    sliderModal.show();

    document.getElementById('sliderMainImage').src = galleryImages[index];

    const thumbsContainer = document.getElementById('sliderThumbnails');
    thumbsContainer.innerHTML = '';

    galleryImages.forEach((src, idx) => {
      const thumb = document.createElement('img');
      thumb.src = src;
      thumb.classList.add('img-thumbnail');
      thumb.style.width = '80px';
      thumb.style.cursor = 'pointer';

      if (idx === index) {
        thumb.classList.add('border', 'border-primary');
      }

      thumb.addEventListener('click', () => {
        document.getElementById('sliderMainImage').src = src;
        thumbsContainer.querySelectorAll('img').forEach(t => t.classList.remove('border', 'border-primary'));
        thumb.classList.add('border', 'border-primary');
      });

      thumbsContainer.appendChild(thumb);
    });
  });
});


JS;
$this->registerJs($script);

?>


