<style>
    .ql-container {
        height: 200px;
    }

    .ql-editor {
        min-height: 100% !important;
    }

    input[type="file"] {
        display: block;
    }

    .imageThumb {
        max-height: 75px;
        border: 2px solid;
        margin-left: 10px;
        margin-bottom: 3px;
        padding: 1px;
        cursor: pointer;
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }


    .cropper-container {
        width: 100% !important;
    }

    .modal-header {
        position: relative;
    }

    .modal-header .closeCrop {
        position: absolute;
        top: 13px;
        right: 15px;
    }

    label#thumbnail_image-error {
        position: absolute;
        top: 9rem !important
    }

    #ndp-nepali-box {
        top: 60px !important;
        left: 10px !important;
    }

    input#nepali-datepicker {
        width: 100% !important;
        height: 50% !important;
        border-radius: 0.2rem !important;
        border: 0.1px solid rgb(236, 231, 231);
        padding-left: 0.5rem !important;
    }
    @import url('https://fonts.googleapis.com/css2?family=Mulish:wght@400;500;600&display=swap');

*,::after,::before {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    min-height: 100vh;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
    font-family: 'Mulish', sans-serif;
    background: #dfe3f2;
}

/* MAIN STYLE */

.card {
    width: 400px;
    height: auto;
    padding: 15px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
    border-radius: 5px;
    overflow: hidden;
    background: #fafbff;
}

.card .top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.card p {
    font-size: 0.9rem;
    font-weight: 600;
    color: #878a9a;
}

.card button {
    outline: 0;
    border: 0;
        -webkit-appearence: none;
	background: #5256ad;
	color: #fff;
	border-radius: 4px;
	transition: 0.3s;
	cursor: pointer;
	font-weight: 400;
	box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
	font-size: 0.8rem;
	padding: 8px 13px;
}

.card button:hover {
	opacity: 0.8;
}

.card button:active {
	transform: translateY(5px);
}

.card .drag-area {
	width: 100%;
	height: 160px;
	border-radius: 5px;
	border: 2px dashed #d5d5e1;
	color: #c8c9dd;
	font-size: 0.9rem;
	font-weight: 500;
	position: relative;
	background: #dfe3f259;
	display: flex;
	justify-content: center;
	align-items: center;
	user-select: none;
	-webkit-user-select: none;
	margin-top: 10px;
}

.card .drag-area .visible {
	font-size: 18px;
}
.card .select {
    color: #5256ad;
	margin-left: 5px;
	cursor: pointer;
	transition: 0.4s;
}

.card .select:hover {
	opacity: 0.6;
}

.card .container {
	width: 100%;
	height: auto;
	display: flex;
	justify-content: flex-start;
	align-items: flex-start;
	flex-wrap: wrap;
	max-height: 200px;
	overflow-y: auto;
	margin-top: 10px;
}

.no-spinner::-webkit-outer-spin-button,
.no-spinner::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.card .container .image {
	width: calc(26% - 19px);
	margin-right: 15px;
	height: 75px;
	position: relative;
	margin-bottom: 8px;
}

.card .container .image img {
	width: 100%;
	height: 100%;
	border-radius: 5px;
}

.card .container .image span {
	position: absolute;
	top: -2px;
	right: 9px;
	font-size: 20px;
	cursor: pointer;
}

/* dragover class will used in drag and drop system */
.card .drag-area.dragover {
	background: rgba(0, 0, 0, 0.4);
}

.card .drag-area.dragover .on-drop {
	display: inline;
	font-size: 28px;
}

.card input,
.card .drag-area .on-drop, 
.card .drag-area.dragover .visible {
	display: none;
}
.card2{
    display: flex;
    justify-content : center;
}

</style>
<div class="modal-header">
    <h1 class="modal-title fs-5" id="staticBackdropLabel">Our Rooms</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form action="{{route('admin.ourroom.save')}}" method="POST" id="postForm" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
            <input type="hidden" name="id" id="id" value="{{ @$prevPost->id }}">
            <label for="category" class="form-label">Category <span class="required-field">*</span></label>
            <select class="form-select" aria-label="Default select example" id="Category" name="category_id">
                -<option value="">Select Category </option>
         @foreach ($category as $roomcategory)
        <option value="{{ $roomcategory->id }}" 
            @if (isset($prevPost) && $prevPost->category_id == $roomcategory->id) selected @endif>
            {{ $roomcategory->category }}
        </option>
         @endforeach
        </select>

        </div>
        <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
            <label for="title" class="form-label">Title <span class="required-field">*</span></label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title..." value="{{ @$prevPost->title }}">
        </div>
        <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3">
            <label for="order_number" class="form-label no-spinner"> Order <span class="required-field">*</span></label>
            <input type="number" class="form-control no-spinner " id="order_number" name="order_number" placeholder="Enter order..." value="{{ @$prevPost->order_number }}">
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col">
            <label for="max_occupancy" class="form-label no-spinner">Max Occupancy <span class="required-field">*</span></label>
            <input type="number" class="form-control no-spinner" id="max_occupancy" name="occupancy" placeholder="Enter max occupancy" value="{{ @$prevPost->max_occupancy }}">
        </div>
        <div class="col">
            <label for="title" class="form-label no-spinner">Room No <span class="required-field">*</span></label>
            <input type="number" class="form-control no-spinner" id="title" name="room_no" placeholder="Enter room number" value="{{ @$prevPost->room_no }}">
        </div>
    </div>

    <!-- Features as Radio Buttons with Conditional Display -->
    <div class="row mt-2">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
            <label for="wifi" class="form-label">Wifi</label>
            <div>
                <input type="radio" id="wifi_y" name="wifi" value="Y" {{ @$prevPost->wifi === 'Y' ? 'checked' : '' }}>
                <label for="wifi_y">Yes</label>
                <!-- Only show "No" if Wifi is not selected as "Yes" -->
                    <input type="radio" id="wifi_n" name="wifi" value="N" {{ @$prevPost->wifi === 'N' ? 'checked' : '' }}>
                    <label for="wifi_n">No</label>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
            <label for="ac" class="form-label">AC</label>
            <div>
                <input type="radio" id="ac_y" name="AC" value="Y" {{ @$prevPost->AC === 'Y' ? 'checked' : '' }}>
                <label for="ac_y">Yes</label>
                <!-- Only show "No" if AC is not selected as "Yes" -->
                    <input type="radio" id="ac_n" name="AC" value="N" {{ @$prevPost->AC === 'N' ? 'checked' : '' }}>
                    <label for="ac_n">No</label>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
            <label for="tv" class="form-label">TV</label>
            <div>
                <input type="radio" id="tv_y" name="TV" value="Y" {{ @$prevPost->TV === 'Y' ? 'checked' : '' }}>
                <label for="tv_y">Yes</label>
                <!-- Only show "No" if TV is not selected as "Yes" -->
                    <input type="radio" id="tv_n" name="TV" value="N" {{ @$prevPost->TV === 'N' ? 'checked' : '' }}>
                    <label for="tv_n">No</label>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
            <label for="minibar" class="form-label">Minibar</label>
            <div>
                <input type="radio" id="minibar_y" name="minibar" value="Y" {{ @$prevPost->minibar === 'Y' ? 'checked' : '' }}>
                <label for="minibar_y">Yes</label>
                <!-- Only show "No" if Minibar is not selected as "Yes" -->
                    <input type="radio" id="minibar_n" name="minibar" value="N" {{ @$prevPost->minibar === 'N' ? 'checked' : '' }}>
                    <label for="minibar_n">No</label>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
            <label for="room_service" class="form-label">Room Service</label>
            <div>
                <input type="radio" id="room_service_y" name="room_service" value="Y" {{ @$prevPost->room_service === 'Y' ? 'checked' : '' }}>
                <label for="room_service_y">Yes</label>
                <!-- Only show "No" if Room Service is not selected as "Yes" -->
                    <input type="radio" id="room_service_n" name="room_service" value="N" {{ @$prevPost->room_service === 'N' ? 'checked' : '' }}>
                    <label for="room_service_n">No</label>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
            <label for="private_bathroom" class="form-label">Private Bathroom</label>
            <div>
                <input type="radio" id="private_bathroom_y" name="private_bathroom" value="Y" {{ @$prevPost->private_bathroom === 'Y' ? 'checked' : '' }}>
                <label for="private_bathroom_y">Yes</label>
                <!-- Only show "No" if Private Bathroom is not selected as "Yes" -->
                    <input type="radio" id="private_bathroom_n" name="private_bathroom" value="N" {{ @$prevPost->private_bathroom === 'N' ? 'checked' : '' }}>
                    <label for="private_bathroom_n">No</label>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
            <label for="balcony" class="form-label">Balcony</label>
            <div>
                <input type="radio" id="balcony_y" name="balcony" value="Y" {{ @$prevPost->balcony === 'Y' ? 'checked' : '' }}>
                <label for="balcony_y">Yes</label>
                <!-- Only show "No" if Balcony is not selected as "Yes" -->
                    <input type="radio" id="balcony_n" name="balcony" value="N" {{ @$prevPost->balcony === 'N' ? 'checked' : '' }}>
                    <label for="balcony_n">No</label>
            </div>
        </div>
    </div>

    
    <div class="row mt-2">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <label for="details" class="form-label">Details <span class="required-field"></span></label>
                <div id="details" name="details">{!! @$prevPost->description !!}</div>
                <input type="hidden" name="details" id="quill-content">
            </div>
    </div>

    <div class="card_2">
    <div class="card">
    	<div class="top">
    		<p>Drag & drop image uploading</p>
    	</div>
    	<div class="drag-area">
    		<span class="visible">
				Drag & drop image here or
				<span class="select" role="button">Browse</span>
			</span>
			<span class="on-drop">Drop images here</span>
    		<input name="file[]" type="file" class="file" multiple />
    	</div>

	    <!-- IMAGE PREVIEW CONTAINER -->
    	<div class="container"></div>
    </div>
    
    <div class="row">
    @if (isset($prevPost->id))
    @if (!empty($decodedFeatureImages) && is_array($decodedFeatureImages))
        @foreach ($decodedFeatureImages as $featureImage)
            <div id="feature_image">
                <img src="{{ asset('/storage/ourroom') . '/' . $featureImage }}"
                     class="_feature-image imageThumb" />
                <button type="button"
                        class="delete_feature_image btn btn-danger label-btn ms-2"
                        id="delete_feature_image"
                        data-feature_image="{{ $featureImage }}">Delete<i
                        class="bi bi-trash label-btn-icon"></i>
                </button>
            </div>
        @endforeach
    @endif
@endif

     </div>
    </div>

</form>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary saveNews"><i class="fa fa-save"></i>
        @if (empty($id))
            Save
        @else
            Update
        @endif
    </button>
</div>

<script>
    $(document).ready(function() {
        
        var quill = new Quill('#details', {
            theme: 'snow'
        });
        $(document).on("change", "#feature_images", function() {
            $('.pip').hide();
        });
        // uploaded image preview end

        $('#thumbnail_image').on('change', function(event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                $('._image').attr('src', URL.createObjectURL(selectedFile));
            }
        });

        //validation
       
        // Save news
        $('.saveNews').off('click');
        $('.saveNews').on('click', function() {
            console.log(utkarshaFiles.length);

            if ($('#postForm').valid()) {
                showLoader();
                var details = quill.root.innerHTML;
                $('#postForm').find('#quill-content').val(details);
                $('#postForm').ajaxSubmit({
                    success: function(response) {
                        if (response) {
                            if (response.type === 'success') {
                                showNotification(response.message, 'success');
                                postTable.draw();
                                $('#postForm')[0].reset();
                                $('#id').val('');
                                $('#postModal').modal('hide');
                                utkarshaFiles = [];
                                console.log(utkarshaFiles);
                                hideLoader();
                            } else {
                                showNotification(response.message, 'error');
                                hideLoader();
                            }
                        }
                        hideLoader();
                    },
                    error: function(xhr) {
                        hideLoader();
                        var response = xhr.responseJSON;
                        showNotification(response ? response.message : 'An error occurred',
                            'error');
                           
                    }
                });
            }
        });

     
        // Delete feature image
        $('.delete_feature_image').off('click')
        $('.delete_feature_image').on('click', function() {
            var deleteButton = $(this);
            Swal.fire({
                title: "Are you sure you want to delete this item",
                text: "You won't be able to revert it!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DB1F48",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();
                    var feature_image = $(this).data('feature_image');
                    var id = $('#id').val();
                    var url = '{{route('admin.ourroom.deletefeatureimage')}}';
                    var data = {
                        feature_image: feature_image,
                        id: id,
                    };
                    $.post(url, data, function(response) {
                        var result = JSON.parse(response);
                        if (result) {
                            if (result.type === 'success') {
                                showNotification(result.message, 'success');
                                deleteButton.closest('#feature_image').remove();
                                hideLoader();
                            } else {
                                showNotification(result.message, 'error');
                                hideLoader();
                            }
                        }
                    });
                }
            });
        });


        $('#postForm').validate({
            rules:{
                title : 'required',
                order_number:"required",
                occupancy: 'required',
                room_no: 'required',
                wifi:'required',
                AC:'required',
                TV:'required',
                minibar:'required',
                details: "required",
                room_service:'required',
                private_bathroom:'required',
                balcony:'required',
                category:'required',
            },
            messages: {
    title: {
        required: "The title field is required."
    },
    details: {
        required:'Please write a description'
    },

    order_number: {
        required: "The order number field is required."
    },
    occupancy: {
        required: "The occupancy field is required."
    },
    room_no: {
        required: "The room number field is required."
    },
    wifi: {
        required: "Please specify if Wi-Fi is available (Y or N)."
    },
    AC: {
        required: "Please specify if AC is available (Y or N)."
    },
    TV: {
        required: "Please specify if TV is available (Y or N)."
    },
    minibar: {
        required: "Please specify if a minibar is available (Y or N)."
    },
    room_service: {
        required: "Please specify if room service is available (Y or N)."
    },
    private_bathroom: {
        required: "Please specify if there is a private bathroom (Y or N)."
    },
    balcony: {
        required: "Please specify if a balcony is available (Y or N)."
    },
    category: {
        required: "Please select a category."
    }
},
highlight: function(element) {
                $(element).addClass('border-danger')
            },
            unhighlight: function(element) {
                $(element).removeClass('border-danger')
            },
        })

    });
</script>
<script>
// <!-- upload multiple photos -->

if (typeof utkarshaFiles === "undefined") {
    var utkarshaFiles = [];  // Declare it only if not already declared
}

dragArea = document.querySelector('.drag-area'),
input = document.querySelector('.drag-area input'),
button = document.querySelector('.card button'),
select = document.querySelector('.drag-area .select'),
container = document.querySelector('.container');

/** CLICK LISTENER */
select.addEventListener('click', () => input.click());

/* INPUT CHANGE EVENT */
input.addEventListener('change', () => {
    let file = input.files;
        
    // if user select no image
    if (file.length == 0) return;
         
    for(let i = 0; i < file.length; i++) {
        if (file[i].type.split("/")[0] != 'image') continue;
        if (!utkarshaFiles.some(e => e.name == file[i].name)) utkarshaFiles.push(file[i]) // Updated variable name to 'utkarshaFiles'
    }
    updateFileInput(); 
    showImages();
});

/** SHOW IMAGES */
function showImages() {
    container.innerHTML = utkarshaFiles.reduce((prev, curr, index) => { // Updated variable name to 'utkarshaFiles'
        return `${prev}
            <div class="image">
                <span onclick="delImage(${index})">&times;</span>
                <img src="${URL.createObjectURL(curr)}" />
            </div>`
    }, '');
}

/* DELETE IMAGE */
function delImage(index) {
    utkarshaFiles.splice(index, 1); 
    updateFileInput();  // Updated variable name to 'utkarshaFiles'
    showImages();
}

/* DRAG & DROP */
dragArea.addEventListener('dragover', e => {
    e.preventDefault()
    dragArea.classList.add('dragover')
})

/* DRAG LEAVE */
dragArea.addEventListener('dragleave', e => {
    e.preventDefault()
    dragArea.classList.remove('dragover')
});

/* DROP EVENT */
dragArea.addEventListener('drop', e => {
    e.preventDefault()
    dragArea.classList.remove('dragover');

    let file = e.dataTransfer.files;
    for (let i = 0; i < file.length; i++) {
        /** Check selected file is image */
        if (file[i].type.split("/")[0] != 'image') continue;
        
        if (!utkarshaFiles.some(e => e.name == file[i].name)) utkarshaFiles.push(file[i]) // Updated variable name to 'utkarshaFiles'
    }
    updateFileInput();
    showImages();
});

function updateFileInput() {
    let input = document.querySelector('.drag-area input');
    
    // Create a new DataTransfer object (for the input field)
    let dataTransfer = new DataTransfer();

    // Add files from utkarshaFiles to the DataTransfer
    utkarshaFiles.forEach(file => {
        dataTransfer.items.add(file);  // Add each file to the DataTransfer
    });

    // Update the input field with the new list of files
    input.files = dataTransfer.files;
}
</script>
