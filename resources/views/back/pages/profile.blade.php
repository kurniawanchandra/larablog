@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Dashboard')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Profile</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Profile
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
@livewire('admin.profile')


{{-- <div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo">
                <a href="modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                <img src="vendors/images/photo1.jpg" alt="" class="avatar-photo">
            </div>
            <h5 class="text-center h5 mb-0">Ross C. Lopez</h5>
            <p class="text-center text-muted font-14">
                Lorem ipsum dolor sit amet
            </p>

            <div class="profile-social">
                <h5 class="mb-20 h5 text-blue">Social Links</h5>
                <ul class="clearfix">
                    <li>
                        <a href="#" class="btn" data-bgcolor="#3b5998" data-color="#ffffff"
                            style="color: rgb(255, 255, 255); background-color: rgb(59, 89, 152);"><i
                                class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="#" class="btn" data-bgcolor="#1da1f2" data-color="#ffffff"
                            style="color: rgb(255, 255, 255); background-color: rgb(29, 161, 242);"><i
                                class="fa fa-twitter"></i></a>
                    </li>
                    <li>
                        <a href="#" class="btn" data-bgcolor="#007bb5" data-color="#ffffff"
                            style="color: rgb(255, 255, 255); background-color: rgb(0, 123, 181);"><i
                                class="fa fa-linkedin"></i></a>
                    </li>
                    <li>
                        <a href="#" class="btn" data-bgcolor="#f46f30" data-color="#ffffff"
                            style="color: rgb(255, 255, 255); background-color: rgb(244, 111, 48);"><i
                                class="fa fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="#" class="btn" data-bgcolor="#c32361" data-color="#ffffff"
                            style="color: rgb(255, 255, 255); background-color: rgb(195, 35, 97);"><i
                                class="fa fa-dribbble"></i></a>
                    </li>
                    <li>
                        <a href="#" class="btn" data-bgcolor="#3d464d" data-color="#ffffff"
                            style="color: rgb(255, 255, 255); background-color: rgb(61, 70, 77);"><i
                                class="fa fa-dropbox"></i></a>
                    </li>
                    <li>
                        <a href="#" class="btn" data-bgcolor="#db4437" data-color="#ffffff"
                            style="color: rgb(255, 255, 255); background-color: rgb(219, 68, 55);"><i
                                class="fa fa-google-plus"></i></a>
                    </li>
                    <li>
                        <a href="#" class="btn" data-bgcolor="#bd081c" data-color="#ffffff"
                            style="color: rgb(255, 255, 255); background-color: rgb(189, 8, 28);"><i
                                class="fa fa-pinterest-p"></i></a>
                    </li>
                    <li>
                        <a href="#" class="btn" data-bgcolor="#00aff0" data-color="#ffffff"
                            style="color: rgb(255, 255, 255); background-color: rgb(0, 175, 240);"><i
                                class="fa fa-skype"></i></a>
                    </li>
                    <li>
                        <a href="#" class="btn" data-bgcolor="#00b489" data-color="#ffffff"
                            style="color: rgb(255, 255, 255); background-color: rgb(0, 180, 137);"><i
                                class="fa fa-vine"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden">
            <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personal_detail" role="tab">Personal
                                Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#update_password" role="tab">Update Password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#social_links" role="tab">Social Links</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Timeline Tab start -->
                        <div class="tab-pane fade show active" id="personal_detail" role="tabpanel">
                            ---- Personal Details ----
                        </div>
                        <div class="tab-pane fade" id="update_password" role="tabpanel">
                            ---- Update Password ----
                        </div>
                        <div class="tab-pane fade height-100-p" id="social_links" role="tabpanel">
                            ---- Social links ----
                        </div>
                        <!-- Setting social links End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
@push('scripts')
<script>
    $('input[type="file"][id="profilePictureFile"]').kropify({
        preview:'image#profilePicturePreview',
        viewMode:1,
        aspectRatio:1,
        cancelButtonText:'Cancel',
        resetButtonText:'Reset',
        cropButtonText:'Crop & update',
        processURL:'{{ route("admin.update_profile_picture") }}',
        maxSize:2097152, //2MB
        showLoader:true,
        success:function(data){
            if(data.status == 1)
        {
            s().notifa({
                vers:2,
                cssClass:'success',
                html:data.message,
                delay:2500
            });
        }else{
             s().notifa({
                vers:2,
                cssClass:'error',
                html:data.message,
                delay:2500
            });
        }
         // console.log(data);
         // console.log(data.status); //Kropify status
         // console.log(data.message); //Kropify message
         // console.log(data.image.getName); //Get cropped image name
         // console.log(data.image.getSize); //Get cropped image size
         // console.log(data.image.getWidth); //Get cropped image width
         // console.log(data.image.getHeight); //Get cropped image height
          },
          errors:function(error, text){
             console.log(text);
          },
        });
</script>
@endpush