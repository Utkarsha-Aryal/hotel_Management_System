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
</style>
@if ($type == 'error')
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">
            Error
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        {{ $message }}
    </div>
@else
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">
            <?php
            $id = $prevFAQ->id ?? null;
            $message = !empty($id) ? 'Update Existing Frequently Asked Questions' : 'Add New Frequently Asked Questions';
            ?>
            <?php echo $message; ?>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form action="{{ route('admin.faq.save') }}" method="POST" id="formFAQ" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="{{ @$prevFAQ->id }}">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <label for="category" class="form-label">FAQ Category <span class="required-field">*</span></label>
                    <select class="form-select" aria-label="Default select example" id="category" name="category">
                        <option selected disabled>Select Category</option>
                        @foreach ($category as $faqCategory)
                            <option value="{{ $faqCategory->id }}" @if (@$prevFAQ->faq_category_id == $faqCategory->id) selected @endif>
                                {{ $faqCategory->name }}</option>
                        @endforeach
                    </select>


                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <label for="order_number" class="form-label">FAQ Order <span class="required-field">*</span></label>
                    <input type="number" class="form-control" id="order_number" name="order_number"
                        placeholder="Enter FAQ order..." value="{{ @$prevFAQ->order_number }}">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <label for="question" class="form-label">Frequently Asked Questions <span
                            class="required-field">*</span></label>
                    <textarea class="form-control" name="question" id="question" placeholder="Frequently Asked Questions...">{{ @$prevFAQ->question }}</textarea>
                </div>
            </div>

            <div class="row mt-2" style="display: none" id="show_event_date_address">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 datepick">
                    <label for="event_date" class="form-label">Event Date <span class="required-field">*</span></label>
                    <p>
                        <input type="text" id="nepali-datepicker" name="" placeholder="Select Event Date">
                    </p>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                    <label for="title" class="form-label">Event Address <span class="required-field">*</span></label>
                    <input type="text" class="form-control" id="" name=""
                        placeholder="Enter event address...">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <label for="answer" class="form-label">Answer <span class="required-field">*</span></label>
                    <!-- Quill Editor Container -->
                    <div id="answer" name="answer">{!! @$prevFAQ->answer !!}</div>
                    <input type="hidden" name="answer" id="quill-content">
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary saveFAQ"><i class="fa fa-save"></i>
            @if (empty($id))
                Save
            @else
                Update
            @endif
        </button>
    </div>
@endif

<script>
    $(document).ready(function() {
        var quill = new Quill('#answer', {
            theme: 'snow'
        });

        $('#formFAQ').validate({
            rules: {
                category: "required",
                order_number: "required",
                answer: "required",
            },
            message: {
                category: {
                    required: "This field is required."
                },
                order_number: {
                    required: "This field is required."
                },
                answer: {
                    required: "This field is required."
                },
            },
            highlight: function(element) {
                $(element).addClass('border-danger')
            },
            unhighlight: function(element) {
                $(element).removeClass('border-danger')
            },
        });


        // Save news
        $('.saveFAQ').off('click');
        $('.saveFAQ').on('click', function() {
            if ($('#formFAQ').valid()) {
                showLoader();

                // Get content from Quill editor
                var answer = quill.root.innerHTML;
                $('#formFAQ').find('#quill-content').val(answer);

                // Submit the form using AJAX
                $('#formFAQ').ajaxSubmit({
                    success: function(response) {
                        if (response) {
                            if (response.type === 'success') {
                                showNotification(response.message, 'success');
                                faqTable.draw();
                                $('#formFAQ')[0].reset();
                                $('#id').val('');
                                $('#modal').modal('hide');
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
                        showNotification(response && response.message ? response.message :
                            'An error occurred', 'error');
                    }
                });

            }
        });
    });
</script>
