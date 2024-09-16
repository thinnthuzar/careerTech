<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="row">
                <div class="col-12 my-3 col-md-6  ">
                    <div class="card bg-white">
                        <div class="col-4">
                            <div class="card_body">
                                <h4>Companies</h4>
                                <p>{{$companies}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12 col-md-6">
                    <div class="card bg-white">
                        <div class="col-4">
                            <div class="card_body">
                                <h4>Employees</h4>
                                <p>{{$employees}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-white mt-5">
                    <h3>Company Lists</h3>
                    @foreach ($company as $p)
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                        <tbody>
                            <tr>
                                <td>{{$p->id}}</td>
                                <td>{{$p->name}}</td>
                                <td>{{$p->email}}</td>

                            </tr>
                        </tbody>
                    </table>
                   @endforeach
                </div>
              
                   
            </div>  
            
               
               
            
        </div>

</x-app-layout>
