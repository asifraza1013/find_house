@extends('layouts.user.layout')
@section('title')
    <title>{{ _('Create Ads') }}</title>
@endsection

<style>
    .counter-wrapper {
        height: auto;
        min-width: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #FFF;
        border-radius: 12px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .counter-wrapper span {
        width: 100%;
        text-align: center;
        font-size: 20px;
        font-weight: 200;
        cursor: pointer;
        user-select: none;
    }

    .counter-wrapper span.num {
        font-size: 20px;
        border-right: 2px solid rgba(0, 0, 0, 0.2);
        border-left: 2px solid rgba(0, 0, 0, 0.2);
        pointer-events: none;
    }

    .counter-wrapper .minus,
    .counter-wrapper .plus {
        background: #B1AB99
    }

    .bg-gray {
        background: #B1AB99
    }

    .thumb {
        height: 150px;
        width: 200px;
        border: 1px solid #000;
    }

    ul.thumb-Images li {
        width: 120px;
        float: left;
        display: inline-block;
        vertical-align: top;
        height: 120px;
    }

    .img-wrap {
        position: relative;
        display: inline-block;
        font-size: 0;
    }

    .img-wrap .close {
        position: absolute;
        top: 2px;
        right: 2px;
        z-index: 100;
        background-color: #d0e5f5;
        padding: 5px 2px 2px;
        color: #000;
        font-weight: bolder;
        cursor: pointer;
        opacity: 0.5;
        font-size: 23px;
        line-height: 10px;
        border-radius: 50%;
    }

    .img-wrap:hover .close {
        opacity: 1;
        background-color: #ff0000;
    }

    .FileNameCaptionStyle {
        font-size: 12px;
    }
</style>
<script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
@section('user-content')
    <div class="row">
        <div class="col-12">
            <div class="wsus__about_tab">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                            type="button" role="tab" aria-controls="pills-home" aria-selected="true" disabled>1.Basic
                            Information</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false" disabled>2.Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                            aria-selected="false" disabled>3.Photos</button>
                    </li>
                </ul>
                <div class="container">
                    <form action="{{ route('store.ads') }}" method="POST" enctype="multipart/form-data" id="create-ads">
                        @csrf
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-xl-6 col-md-6">
                                        <h2 class="text-center">Publish your private vendor listing</h2>

                                        <div class="form-group mt-3">
                                            <label
                                                for="category">{{ $websiteLang->where('lang_key', 'property_type')->first()->custom_text }}
                                                <span class="text-danger">*</span></label>
                                            <select name="property_type" id="property_type"
                                                class="form-control">
                                                <option value="">
                                                    {{ $websiteLang->where('lang_key', 'select_property_type')->first()->custom_text }}
                                                </option>
                                                @foreach ($propertyTypes as $item)
                                                    <option {{ old('property_type') == $item->id ? 'selected' : '' }}
                                                        value="{{ $item->id }}">{{ $item->type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <h5>Transactions</h5>
                                            <select name="transactions" id="transactions" class="form-control">
                                                <option value="">Select Transaction Type</option>
                                                @foreach (config('constants.ad_transactions') as $key => $item)
                                                    <option {{ old('property_type') == $key ? 'selected' : '' }}
                                                        value="{{ $key }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <h5>Location Of the property</h5>
                                            <input type="text" name="location" value="{{ old('location') }}"
                                                class="form-control" placeholder="Location" id="location">
                                            <input type="hidden" name="lat" id="lat">
                                            <input type="hidden" name="lng" id="lng">
                                            <input type="text" name="street_name" value="{{ old('street_name') }}"
                                                class="form-control mt-1" placeholder="Street Name" id="street-name">
                                            <input type="text" name="street_no" value="{{ old('street_no') }}"
                                                class="form-control mt-1" placeholder="Streen Number" id="street-no">
                                            <p class="mt-1">Do you want to hide the street name and number? (optional)</p>
                                            <input id="hide" value="hide" type="checkbox" name="hide_street">
                                            <span>Hide
                                                address for {{ config('constants.hide_address_fee') }}
                                                {{ $settings->currency_icon }}</span>
                                            <input type="text" name="residential_area"
                                                value="{{ old('resdential_area') }}" class="form-control mt-1"
                                                placeholder="Residential area (optional)">

                                            <h5 class="mt-3">Your contact details</h5>
                                            <label for="category">Your email <span class="text-danger">*</span></label>
                                            <input type="text" name="email" value="{{ old('email') }}"
                                                class="form-control mt-1" placeholder="Email" id="email">
                                            <label for="category">Your phone number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="phone" value="{{ old('phone') }}"
                                                class="form-control mt-1" placeholder="Phone" id="phone">
                                            <small>Keep your phone handy to post your listing.</small>
                                            <label for="category">Your name<span class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control mt-1" placeholder="Name" id="name">
                                            <small>It will be shown on your listing and when you contact other users</small>

                                            <h5 class="mt-3">How do you prefer to be contacted?</h5>
                                            <input id="hide" type="radio" name="prefer_connection"
                                                value="phone_chat"/> <span>Phone and chat messages (recommended)</span> <br>
                                            <input id="hide1" type="radio" name="prefer_connection"
                                                value="chat"> <span>Only by chat messages</span>
                                            <br><br>
                                            <button class="common_btn" id="step2">Continue to listing details</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-6 col-md-6 mt-auto mb-auto">
                                        <div class="card">
                                            <div class="card-body bg-light">
                                                <p>Have your pictures handy. If you don't have them, you can
                                                    add them later. Without pictures you won't get results.
                                                    We give you the first two listings for free to let you try our
                                                    service. You can publish free listings for flats, houses,
                                                    garages, plots, commercial properties, etc. until you sell or
                                                    rent them.

                                                    In addition, you can publish up to 5 rooms in a shared flat
                                                    for free and these are not included within the number of
                                                    listings we give you.

                                                    In order to maintain the quality of our service, we need to
                                                    charge a fee in the following cases:</p>
                                                <p class="mt-5">1. advertisers with more than two listings</p>
                                                <p class="mt-1">2. duplicated property listings</p>
                                                <p class="mt-1">3. properties for sale for more than 1,000,000 €</p>
                                                <p class="mt-1">4. properties for rent for more than 2,000 €/month</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="col-12 col-lg-6 col-xl-6 col-md-6">
                                    <h2 class="text-center">Features of the country home</h2>
                                    <div class="form-group mt-3">
                                        <h5>Type of country home</h5>
                                        <select name="country" id="country" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($country as $item)
                                                <option {{ old('country') == $item->name ? 'selected' : '' }}
                                                    value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <h5 class="mt-2">Condition</h5>
                                        @foreach (config('constants.condition') as $key=>$item)
                                        <input type="radio" name="condition"
                                        value="{{ $key }}" {{ (old('condition') == $key) ? 'selected': null }}> <span>{{ $item }}</span> <br>
                                        @endforeach
                                        {{-- <input id="hide" type="radio" name="condition"
                                            value="1"> <span>Needs renovating</span> <br>
                                        <input id="hide" type="radio" name="condition"
                                            value="2"> <span>Good condition</span> --}}

                                        <input type="text" name="built_area" value="{{ old('built_area') }}"
                                            class="form-control mt-2" placeholder="Built Area m²" id="built-area">
                                        <input type="text" name="useable_area" value="{{ old('useable_area') }}"
                                            class="form-control mt-1" placeholder="Usable area (optional) m²">
                                        <input type="text" name="plot_area" value="{{ old('plot_area') }}"
                                            class="form-control mt-1" placeholder="Plot area (optional) m²">

                                        <h5 class="mt-2">Number of bedrooms in the property</h5>
                                        <div class="counter-wrapper w-50">
                                            <span class="b-minus bg-gray">-</span>
                                            <span class="b-num">01</span>
                                            <input type="hidden" class="form-control" name="bedroom" id="bedrooms"
                                                value="01" id="bedroom">
                                            <span class="b-plus bg-gray">+</span>
                                        </div>

                                        <h5 class="mt-2">Number of toilets and bathrooms</h5>
                                        <div class="counter-wrapper w-50">
                                            <span class="t-minus bg-gray">-</span>
                                            <span class="t-num">01</span>
                                            <input type="hidden" class="form-control" name="toilets" id="toilets"
                                                value="01" id="toilets">
                                            <span class="t-plus bg-gray">+</span>
                                        </div>

                                        <h5 class="mt-2">Orientation (optional)</h5>
                                        @foreach (config('constants.orientation') as $item)
                                            <input id="" value="{{ $item }}" type="radio"
                                                name="orientation"> <span>{{ $item }}</span> <br>
                                        @endforeach

                                        <h5 class="mt-2">Number of floors (optional)</h5>
                                        <div class="counter-wrapper w-50">
                                            <span class="f-minus bg-gray">-</span>
                                            <span class="f-num">01</span>
                                            <input type="hidden" class="form-control" name="floors" id="floors"
                                                value="01">
                                            <span class="f-plus bg-gray">+</span>
                                        </div>

                                        <h5 class="mt-2">Other features of your country home</h5>
                                        @foreach (config('constants.feature_country_home') as $item)
                                            <input id="" value="{{ $item }}" type="checkbox"
                                                name="other_features[]"> <span>{{ $item }}</span> <br>
                                        @endforeach

                                        <h5 class="mt-2">Other features of the building</h5>
                                        @foreach (config('constants.building_feature') as $item)
                                            <input id="" value="{{ $item }}" type="checkbox"
                                                name="building_features[]"> <span>{{ $item }}</span> <br>
                                        @endforeach

                                        <h5 class="mt-2">Price</h5>
                                        <input type="text" name="price" value="{{ old('price') }}"
                                            class="form-control mt-1" placeholder="Price {{ $settings->currency_icon }}" id="price">
                                        <input type="text" name="community_cost" value="{{ old('community_cost') }}"
                                            class="form-control mt-1"
                                            placeholder="Community costs (optional) {{ $settings->currency_icon }}">

                                        <h5 class="mt-2">Ad description</h5>
                                        <small>Use this space to talk about features not covered by the questions or not
                                            shown
                                            in the photos: parquet flooring, type of heating, garden...</small>
                                        <h5 class="mt-2">In English</h5>
                                        <textarea name="description_eng" id="description-en" cols="30" rows="8" class="form-control"></textarea>
                                        <h5 class="mt-2">In Spanish</h5>
                                        <textarea name="description_spa" id="description-spa" cols="30" rows="8" class="form-control"></textarea>

                                        <p class="mt-2">
                                            This will be read more frequently You can add other languages later. Capital
                                            letters
                                            make reading more difficult, so we can't allow the whole description to be
                                            written
                                            in capitals.
                                        </p>
                                    </div>
                                    <button class="common_btn" id="step3">Continue to Upload Photos</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <div>
                                    <div class="form-group">
                                        <input type="file" name="files[]" id="files" multiple
                                            accept="image/jpeg, image/png, image/gif,"
                                            class="form-control fileinput-button"><br />
                                    </div>
                                </div>
                                <output id="Filelist"></output>
                                <br><br><br>
                                <button class="common_btn" type="button" id="step4">Publish</button>
                                <br><br><br><br><br><br>
                                <div class="row dummy-image">
                                    @for ($i = 1; $i <= 9; $i++)
                                        <div class="col-3 bg-light m-1 border-1" style="height: 200px; border:1px solid">
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>
    <script>
        // const validate = new window.JustValidate('#create-ads');
        const validation = new JustValidate(
        '#create-ads',
        {
            errorFieldCssClass: 'is-invalid',
            errorFieldStyle: {
            border: '1px solid red',
            },
            errorLabelCssClass: 'is-label-invalid',
            errorLabelStyle: {
            color: 'red',
            textDecoration: 'underlined',
            },
            focusInvalidField: true,
            lockForm: true,
            tooltip: {
            position: 'top',
            },
            errorContainer: '.errors-container',
        });
        validation
            .addField('#property_type', [{
                rule: 'required',
                errorMessage: 'Property type is required',
            }, ])
            .addField('#transactions', [{
                rule: 'required',
                errorMessage: 'Transactions type is required',
            }, ])
            .addField('#email', [{
                    rule: 'required',
                    errorMessage: 'Email is required',
                },
                {
                    rule: 'email',
                    errorMessage: 'Email is invalid!',
                },
            ])
            .addField('#location', [{
                    rule: 'required',
                    errorMessage: 'Location is required',
                },
            ])
            .addField('#street-name', [{
                    rule: 'required',
                    errorMessage: 'Street name is required',
                },
            ])
            .addField('#street-no', [{
                    rule: 'required',
                    errorMessage: 'Street Number is required',
                },
            ])
            .addField('#phone', [{
                    rule: 'required',
                    errorMessage: 'Phone Number is required',
                },
            ])
            .addField('#name', [{
                    rule: 'required',
                    errorMessage: 'Name is required',
                },
            ])
            // .addField('#prefer-connection', [{
            //         rule: 'required',
            //         errorMessage: 'Prefer to be contacted is required',
            //     },
            // ])
            .addField('#country', [{
                    rule: 'required',
                    errorMessage: 'country home is required',
                },
            ])
            // .addField('#condition', [{
            //         rule: 'required',
            //         errorMessage: 'condition is required',
            //     },
            // ])
            .addField('#built-area', [{
                    rule: 'required',
                    errorMessage: 'Built area is required',
                },
            ])
            .addField('#bedrooms', [{
                    rule: 'required',
                    errorMessage: 'Total bedrooms number is required',
                },
            ])
            .addField('#toilets', [{
                    rule: 'required',
                    errorMessage: 'Total toilet number is required',
                },
            ])
            .addField('#price', [{
                    rule: 'required',
                    errorMessage: 'Price is required',
                },
            ])
            .addField('#description-en', [{
                validator: (value) => {
                    return value[0] === '!';
                },
                },
            ])
            .addField('#description-spa', [{
                    rule: 'required',
                    errorMessage: 'Description is required',
                },
            ])
            .addField('#files', [{
                    rule: 'required',
                    errorMessage: 'Images is required',
                },
        ]);

        $('#step2').on('click', function(){
            console.log('clicked1');
            $('#pills-profile-tab').attr('disabled', false);
            $('#pills-profile-tab').click();
            $('#pills-profile-tab').attr('disabled', true);
        })
        $('#step3').on('click', function(){
            console.log('clicked2');
            $('#pills-contact-tab').attr('disabled', false)
            $('#pills-contact-tab').click();
            $('#pills-contact-tab').attr('disabled', true)
        })

        $('#step4').on('click', function(){
            console.log('submitting form');
            $('#create-ads').submit();
        })
        // bedrooms
        const bplus = document.querySelector(".b-plus"),
            bminus = document.querySelector(".b-minus"),
            bspan = document.querySelector(".b-num");
        bnum = $("#bedrooms");
        let ba = 1;
        bplus.addEventListener("click", () => {
            ba++;
            ba = (ba < 10) ? "0" + ba : ba;
            bspan.innerText = ba
            bnum.val(ba);
        });

        bminus.addEventListener("click", () => {
            if (ba > 1) {
                ba--;
                ba = (ba < 10) ? "0" + ba : ba;
                bspan.innerText = ba
                bnum.val(ba);
            }
        });

        // toilets
        const tplus = document.querySelector(".t-plus"),
            tminus = document.querySelector(".t-minus"),
            tspan = document.querySelector(".t-num");
        tnum = $("#toilets");
        let ta = 1;
        tplus.addEventListener("click", () => {
            ta++;
            ta = (ta < 10) ? "0" + ta : ta;
            tspan.innerText = ta
            tnum.val(ta);
        });

        tminus.addEventListener("click", () => {
            if (ta > 1) {
                ta--;
                ta = (ta < 10) ? "0" + ta : ta;
                tspan.innerText = ta
                tnum.val(ta);
            }
        });

        // floors
        const fplus = document.querySelector(".f-plus"),
            fminus = document.querySelector(".f-minus"),
            fspan = document.querySelector(".f-num");
        fnum = $("#floors");
        let fa = 1;
        fplus.addEventListener("click", () => {
            fa++;
            fa = (fa < 10) ? "0" + fa : fa;
            fspan.innerText = fa
            fnum.val(fa);
        });

        fminus.addEventListener("click", () => {
            if (fa > 1) {
                fa--;
                fa = (fa < 10) ? "0" + fa : fa;
                fspan.innerText = fa
                fnum.val(fa);
            }
        });


        //I added event handler for the file upload control to access the files properties.
        document.addEventListener("DOMContentLoaded", init, false);

        //To save an array of attachments
        var AttachmentArray = [];

        //counter for attachment array
        var arrCounter = 0;

        //to make sure the error message for number of files will be shown only one time.
        var filesCounterAlertStatus = false;

        //un ordered list to keep attachments thumbnails
        var ul = document.createElement("ul");
        ul.className = "thumb-Images";
        ul.id = "imgList";

        function init() {
            //add javascript handlers for the file upload event
            document
                .querySelector("#files")
                .addEventListener("change", handleFileSelect, false);
        }

        //the handler for file upload event
        function handleFileSelect(e) {
            //to make sure the user select file/files
            if (!e.target.files) return;

            //To obtaine a File reference
            var files = e.target.files;

            // Loop through the FileList and then to render image files as thumbnails.
            for (var i = 0, f;
                (f = files[i]); i++) {
                //instantiate a FileReader object to read its contents into memory
                var fileReader = new FileReader();

                // Closure to capture the file information and apply validation.
                fileReader.onload = (function(readerEvt) {
                    return function(e) {
                        //Apply the validation rules for attachments upload
                        ApplyFileValidationRules(readerEvt);

                        //Render attachments thumbnails.
                        RenderThumbnail(e, readerEvt);

                        //Fill the array of attachment
                        FillAttachmentArray(e, readerEvt);
                    };
                })(f);

                // Read in the image file as a data URL.
                // readAsDataURL: The result property will contain the file/blob's data encoded as a data URL.
                // More info about Data URI scheme https://en.wikipedia.org/wiki/Data_URI_scheme
                fileReader.readAsDataURL(f);
            }
            document
                .getElementById("files")
                .addEventListener("change", handleFileSelect, false);
        }

        //To remove attachment once user click on x button
        jQuery(function($) {
            $("div").on("click", ".img-wrap .close", function() {
                var id = $(this)
                    .closest(".img-wrap")
                    .find("img")
                    .data("id");

                //to remove the deleted item from array
                var elementPos = AttachmentArray.map(function(x) {
                    return x.FileName;
                }).indexOf(id);
                if (elementPos !== -1) {
                    AttachmentArray.splice(elementPos, 1);
                }

                //to remove image tag
                $(this)
                    .parent()
                    .find("img")
                    .not()
                    .remove();

                //to remove div tag that contain the image
                $(this)
                    .parent()
                    .find("div")
                    .not()
                    .remove();

                //to remove div tag that contain caption name
                $(this)
                    .parent()
                    .parent()
                    .find("div")
                    .not()
                    .remove();

                //to remove li tag
                var lis = document.querySelectorAll("#imgList li");
                for (var i = 0;
                    (li = lis[i]); i++) {
                    if (li.innerHTML == "") {
                        li.parentNode.removeChild(li);
                    }
                }
            });
        });

        //Apply the validation rules for attachments upload
        function ApplyFileValidationRules(readerEvt) {
            //To check file type according to upload conditions
            if (CheckFileType(readerEvt.type) == false) {
                alert(
                    "The file (" +
                    readerEvt.name +
                    ") does not match the upload conditions, You can only upload jpg/png/gif files"
                );
                e.preventDefault();
                return;
            }

            //To check file Size according to upload conditions
            if (CheckFileSize(readerEvt.size) == false) {
                alert(
                    "The file (" +
                    readerEvt.name +
                    ") does not match the upload conditions, The maximum file size for uploads should not exceed 300 KB"
                );
                e.preventDefault();
                return;
            }

            //To check files count according to upload conditions
            if (CheckFilesCount(AttachmentArray) == false) {
                if (!filesCounterAlertStatus) {
                    filesCounterAlertStatus = true;
                    alert(
                        "You have added more than 20 files. According to upload conditions you can upload 20 files maximum"
                    );
                }
                e.preventDefault();
                return;
            }
        }

        //To check file type according to upload conditions
        function CheckFileType(fileType) {
            if (fileType == "image/jpeg") {
                return true;
            } else if (fileType == "image/png") {
                return true;
            } else if (fileType == "image/gif") {
                return true;
            } else {
                return false;
            }
            return true;
        }

        //To check file Size according to upload conditions
        function CheckFileSize(fileSize) {
            if (fileSize < 1200000) {
                return true;
            } else {
                return false;
            }
            return true;
        }

        //To check files count according to upload conditions
        function CheckFilesCount(AttachmentArray) {
            //Since AttachmentArray.length return the next available index in the array,
            //I have used the loop to get the real length
            var len = 0;
            for (var i = 0; i < AttachmentArray.length; i++) {
                if (AttachmentArray[i] !== undefined) {
                    len++;
                }
            }
            //To check the length does not exceed 10 files maximum
            if (len > 20) {
                return false;
            } else {
                return true;
            }
        }

        //Render attachments thumbnails.
        function RenderThumbnail(e, readerEvt) {
            var li = document.createElement("li");
            ul.appendChild(li);
            li.innerHTML = [
                '<div class="img-wrap"> <span class="close">&times;</span>' +
                '<img class="thumb" src="',
                e.target.result,
                '" title="',
                escape(readerEvt.name),
                '" data-id="',
                readerEvt.name,
                '"/>' + "</div>"
            ].join("");

            var div = document.createElement("div");
            div.className = "FileNameCaptionStyle";
            li.appendChild(div);
            div.innerHTML = [readerEvt.name].join("");
            $('.dummy-image').addClass('d-none')
            document.getElementById("Filelist").insertBefore(ul, null);
        }

        //Fill the array of attachment
        function FillAttachmentArray(e, readerEvt) {
            AttachmentArray[arrCounter] = {
                AttachmentType: 1,
                ObjectType: 1,
                FileName: readerEvt.name,
                FileDescription: "Attachment",
                NoteText: "",
                MimeType: readerEvt.type,
                Content: e.target.result.split("base64,")[1],
                FileSizeInBytes: readerEvt.size
            };
            arrCounter = arrCounter + 1;
        }
    </script>
@endsection
