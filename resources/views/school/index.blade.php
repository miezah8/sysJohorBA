@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <h5 class="mb-0">List of School</h5>
            {{-- <p class="text-sm mb-0">
                A lightweight, extendable, dependency-free javascript HTML table plugin.
            </p> --}}
        </div>
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-search">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>School Name</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-sm font-weight-normal">Tiger Nixon</td>
                        <td class="text-sm font-weight-normal">
                            System Architect
                        </td>
                        <td class="text-sm font-weight-normal">Edinburgh</td>
                        <td class="text-sm font-weight-normal">61</td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">
                            Garrett Winters
                        </td>
                        <td class="text-sm font-weight-normal">Accountant</td>
                        <td class="text-sm font-weight-normal">Tokyo</td>
                        <td class="text-sm font-weight-normal">63</td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Ashton Cox</td>
                        <td class="text-sm font-weight-normal">
                            Junior Technical Author
                        </td>
                        <td class="text-sm font-weight-normal">San Francisco</td>
                        <td class="text-sm font-weight-normal">66</td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Cedric Kelly</td>
                        <td class="text-sm font-weight-normal">
                            Senior Javascript Developer
                        </td>
                        <td class="text-sm font-weight-normal">Edinburgh</td>
                        <td class="text-sm font-weight-normal">22</td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Airi Satou</td>
                        <td class="text-sm font-weight-normal">Accountant</td>
                        <td class="text-sm font-weight-normal">Tokyo</td>
                        <td class="text-sm font-weight-normal">33</td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">
                            Brielle Williamson
                        </td>
                        <td class="text-sm font-weight-normal">
                            Integration Specialist
                        </td>
                        <td class="text-sm font-weight-normal">New York</td>
                        <td class="text-sm font-weight-normal">61</td>
                     
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">
                            Herrod Chandler
                        </td>
                        <td class="text-sm font-weight-normal">
                            Sales Assistant
                        </td>
                        <td class="text-sm font-weight-normal">San Francisco</td>
                        <td class="text-sm font-weight-normal">59</td>
                       
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Rhona Davidson</td>
                        <td class="text-sm font-weight-normal">
                            Integration Specialist
                        </td>
                        <td class="text-sm font-weight-normal">Tokyo</td>
                        <td class="text-sm font-weight-normal">55</td>
                    
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Colleen Hurst</td>
                        <td class="text-sm font-weight-normal">
                            Javascript Developer
                        </td>
                        <td class="text-sm font-weight-normal">San Francisco</td>
                        <td class="text-sm font-weight-normal">39</td>
                  
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Sonya Frost</td>
                        <td class="text-sm font-weight-normal">
                            Software Engineer
                        </td>
                        <td class="text-sm font-weight-normal">Edinburgh</td>
                        <td class="text-sm font-weight-normal">23</td>
             
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Jena Gaines</td>
                        <td class="text-sm font-weight-normal">Office Manager</td>
                        <td class="text-sm font-weight-normal">London</td>
                        <td class="text-sm font-weight-normal">30</td>
         
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Quinn Flynn</td>
                        <td class="text-sm font-weight-normal">Support Lead</td>
                        <td class="text-sm font-weight-normal">Edinburgh</td>
                        <td class="text-sm font-weight-normal">22</td>
     
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">
                            Charde Marshall
                        </td>
                        <td class="text-sm font-weight-normal">
                            Regional Director
                        </td>
                        <td class="text-sm font-weight-normal">San Francisco</td>
                        <td class="text-sm font-weight-normal">36</td>
     
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Haley Kennedy</td>
                        <td class="text-sm font-weight-normal">
                            Senior Marketing Designer
                        </td>
                        <td class="text-sm font-weight-normal">London</td>
                        <td class="text-sm font-weight-normal">43</td>
   
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">
                            Tatyana Fitzpatrick
                        </td>
                        <td class="text-sm font-weight-normal">
                            Regional Director
                        </td>
                        <td class="text-sm font-weight-normal">London</td>
                        <td class="text-sm font-weight-normal">19</td>
           
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Michael Silva</td>
                        <td class="text-sm font-weight-normal">
                            Marketing Designer
                        </td>
                        <td class="text-sm font-weight-normal">London</td>
                        <td class="text-sm font-weight-normal">66</td>
               
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Paul Byrd</td>
                        <td class="text-sm font-weight-normal">
                            Chief Financial Officer (CFO)
                        </td>
                        <td class="text-sm font-weight-normal">New York</td>
                        <td class="text-sm font-weight-normal">64</td>
             
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Gloria Little</td>
                        <td class="text-sm font-weight-normal">
                            Systems Administrator
                        </td>
                        <td class="text-sm font-weight-normal">New York</td>
                        <td class="text-sm font-weight-normal">59</td>
          
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Bradley Greer</td>
                        <td class="text-sm font-weight-normal">
                            Software Engineer
                        </td>
                        <td class="text-sm font-weight-normal">London</td>
                        <td class="text-sm font-weight-normal">41</td>
         
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Dai Rios</td>
                        <td class="text-sm font-weight-normal">Personnel Lead</td>
                        <td class="text-sm font-weight-normal">Edinburgh</td>
                        <td class="text-sm font-weight-normal">35</td>
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">
                            Jenette Caldwell
                        </td>
                        <td class="text-sm font-weight-normal">
                            Development Lead
                        </td>
                        <td class="text-sm font-weight-normal">New York</td>
                        <td class="text-sm font-weight-normal">30</td>
         
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Yuri Berry</td>
                        <td class="text-sm font-weight-normal">
                            Chief Marketing Officer (CMO)
                        </td>
                        <td class="text-sm font-weight-normal">New York</td>
                        <td class="text-sm font-weight-normal">40</td>
                  
                    </tr>
                    <tr>
                        <td class="text-sm font-weight-normal">Caesar Vance</td>
                        <td class="text-sm font-weight-normal">
                            Pre-Sales Support
                        </td>
                        <td class="text-sm font-weight-normal">New York</td>
                        <td class="text-sm font-weight-normal">40</td>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const dataTableSearch = new simpleDatatables.DataTable(
            "#datatable-search", {
                searchable: true,
                fixedHeight: true,
            }
        );
    </script>
@endpush
