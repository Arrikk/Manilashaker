<?php
function __gallery_show_case()
{
?>
    <script>
        $(document).ready(function() {

            // let galleryImage
            let pathName = location.pathname;
            let type = '', input;

            switch (pathName) {
                case '/admin/product/new':
                case '/admin/post/new':
                case '/admin/product/categories':
                    galleryImage()
                    break;

                default:
                    break;
            }

            function galleryImage() {
                fetch('/site/gallery/gallery')
                    .then(res => res.json())
                    .then(data => {
                        gallery = data
                        data.forEach(d => {
                            $('.gallery-preview-image').append(`
                                <div class="col-12 col-lg-2 col-md-3 col-sm-4">
                                    <div class="card gallery-preview-card">
                                        <img src="/${d}" alt="" class="gallery-preview-img">
                                    </div>
                                </div>
                            `)
                        });
                    })
            }

            $(document).on('click', 'a#cke_26', function(){
                type = 'text'
                setTimeout(() => {
                $('#exampleFullScreenModal').modal('show')
                    input = $('input#cke_80_textInput')
                    $('input#cke_80_textInput').after('<button type="button" data-type="text" class="_open_image_gallery btn btn-primary">Gallery</button>')
                }, 2000)
            })

            $(document).on('click', 'input#cke_80_textInput', function(){
                $('button._open_image_gallery').remove()
                $(this).after('<button type="button" data-type="text" class="_open_image_gallery btn btn-primary">Gallery</button>')
            })
            
            $(document).on('click', 'a#cke_139_uiElement, #cke_dialog_close_button_75, #cke_137_uiElement', function(){
                $('button._open_image_gallery').remove()
                type = ''
            })

            $(document).on('click', '._open_image_gallery', function(){
                $('#exampleFullScreenModal').modal('show')
                type = $(this).data('type')
                console.log(type)   
            })


            $(document).on('click', '.gallery-preview-img', function() {
                let link = $(this).attr('src');
                if(type == 'text'){
                    $(input).val(link)
                    navigator.clipboard.writeText(link)
                    alert('Url copied to clipboard')
                }else{
                    $('.choose-featured').fadeOut()
                    $('.featured-image-img').attr('src', link).removeClass('d-none');
                    $('input#__image').val(link)
                }

                $('#exampleFullScreenModal').modal('hide')
                type = ''
            })
        })
    </script>
<?php
}
