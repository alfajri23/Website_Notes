<div id="main" class="">


@include('layouts.sidebar')

<div id="main-page" class="container-fluid d-flex p-3">
    <!-- content-page -->
    <div id="content-page" class="">
    <!-- Header card  -->
        <div class="row my-3 d-flex justify-content-between align-items-center px-5 header">
            <h2 class="my-3 font-weight-bold">Your Notes</h2>
            <div class="row my-3 header-search">
                <!-- search -->
                <div class="col-8 ">
                    <input type="text" class="form-control" placeholder="search" wire:model="search"> 
                </div>  
                <!-- end search -->

                <!-- dropdown -->
                <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter
                </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button class="dropdown-item" wire:click="filter_judul()">Judul</button>
                        <button class="dropdown-item" wire:click="filter_date()">Waktu</button>
                        <button class="dropdown-item" wire:click="filter_now_date()">Hari ini</button>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" wire:click="add_role()">Akses user</button>
                        <button class="dropdown-item" wire:click="del_role()">Hapus akses</button>
                    </div>
                </div>
                <!--end dropdown -->
            </div>
        </div>
    <!-- End Header card -->

    <!-- Menu card -->
        <div class="row mt-4 d-flex justify-content-center px-3">     
                <span class="d-flex justify-content-center align-items-center flex-wrap filter">
                    <button wire:click.prevent="show_all()" class="btn badge badge-info text-white badge-pill m-1 px-3 pt-2"><h6>Semua</h6></button>

                    <button wire:click.prevent="filter_now_date()" class="btn badge badge-secondary text-white badge-pill m-1 px-3 pt-2"><h6>Hari ini</h6></button>

                    <button wire:click.prevent="filter_pending()" class="btn badge badge-primary text-white badge-pill m-1 px-3 pt-2"><h6>Pending</h6></button>

                    <button wire:click.prevent="filter_done()" class="btn badge badge-success text-white badge-pill m-1 px-3 pt-2"><h6>Selesai</h6></button>

                    <button wire:click.prevent="filter_passed()" class="btn badge badge-danger text-white badge-pill m-1 px-3 pt-2"><h6>Terlewat</h6></button>
                    
                </span>
        </div>
    <!-- End Menu Card -->

    <!-- Card -->
        <div id="card" class="container-fluid d-flex ">
            <div class="container d-flex flex-row flex-wrap p-4">
            @foreach ($note as $data)
                    <div class="card m-1 konten" >
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span><h4 class="card-title d-inline">{{$data->judul}}</h4></span>
                            <!-- <span><p>id : {{$data->id}}</p></span> -->
                                @if($data->status=="passed")
                                    <span class="badge badge-danger">{{$data->status}}</span>
                                @elseif($data->status=="pending")
                                    <span class="badge badge-primary">{{$data->status}}</span>
                                @elseif($data->status=="done")
                                    <span class="badge badge-success">{{$data->status}}</span>
                                @endif
                        </div>
                        
                        
                        <h6 class="card-subtitle mb-2 mt-1 text-muted">{{ $data->deadline }}</h6>
                        <p class="card-text">{{$data->desc}}</p>
                        @if($data->status!="done")
                            <button type="button" wire:click.prevent="update_status({{ $data->id }},'done')" class="btn btn-outline-primary btn-sm">Selesai</button>
                            <button type="button" wire:click="edit({{ $data->id }})" class="btn btn-outline-success btn-sm edit" wire:loading.class="bg-gray">Edit</button>
                            <div wire:loading wire:target="edit({{ $data->id }})">
                                Loading...
                            </div>
                        @endif
                        <button type="button" wire:click="delete({{ $data->id }})" class="btn btn-outline-danger btn-sm">Hapus</button>   
                        <div wire:loading wire:target="delete({{ $data->id }})">
                            Menghapus...
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    <!-- End Card -->

    <!-- Paginate -->
        <div class="row my-3 px-5 d-flex justify-content-between">
            
            @hasrole('user')
            <span>
            <select class="form-control" wire:model="paginate">
                <option value="4">4</option>
                <option value="6">6</option>
                <option value="8">8</option>
                <option value="10">10</option>
            </select>
            </span>
            <span class="mr-5">
                {{$note->links()}}
            </span>
            
            @endhasrole
        </div>
    <!-- End Paginate -->
    </div>

    <!-- end-content-page -->

    <!-- add-notes -->
    <div id="add-notes" class="">
        <!-- Add Edit Header -->
        <div class="row">
        @if($edit)
            <h3 class="mt-4 mx-auto">Edit notes</h3>
        @else
            <h3 class="mt-4 mx-auto">Tambah notes</h3>
        @endif
        </div>
        <!-- End Add Edit Header -->

        <div class="row d-flex justify-content-center">
            <form class="col">
                <div class="form-group">
                    <label for="exampleInputEmail1">Judul</label>
                    <input type="text" class="form-control" aria-describedby="textHelp" wire:model="judul">
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Deskripsi</label>
                    <input type="text" class="form-control" wire:model="desc">
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Deadline</label>
                    <input type="date" class="form-control" wire:model="deadline">
                </div>

                @if($edit)
                    <button wire:click.prevent="store()" type="submit" class="btn btn-success">Edit</button>
                    <button wire:click.prevent="cancel_edit()" type="submit" class="btn btn-danger">Cancel</button>
                @else
                    <button wire:click.prevent="store()" type="submit" class="btn btn-primary">Submit</button>
                @endif

            </form>
        </div>
    </div>

    <span>
        <span id="add-notes-logo" class="d-none justify-content-center align-items-center rounded-circle">
            <span class="plus-logo">+</span>
        </span>
    </span>

    <!-- add-notes -->
</div>

</div>
