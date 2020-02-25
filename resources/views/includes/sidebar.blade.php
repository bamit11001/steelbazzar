     <aside id="slide-out" class="side-nav white fixed">
                <div class="side-nav-wrapper">
                    <div class="sidebar-profile">
                        <div class="sidebar-profile-image">
                            <img src="../assets/images/profile-image.png" class="circle" alt="">
                        </div>
                        <div class="sidebar-profile-info">
                       
                                <p>Admin</p>

                         
                        </div>
                    </div>
            
                <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
                    <li class="no-padding"><a class="waves-effect waves-grey" href="{{route('dashboard')}}"><i class="material-icons">settings_input_svideo</i>Dashboard</a></li>
                    <li class="no-padding">
                        <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">account_box</i>Settings<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{route('category')}}">Categories</a></li>
                                <li><a href="{{route('item')}}">Items</a></li>
                                <li><a href="{{route('area')}}">Area</a></li>
                                <li><a href="{{route('itemtoarea')}}">Link Item Area</a></li>
                                <li><a href="{{route('plans')}}">Plans</a></li>
       
                            </ul>
                        </div>
                    </li>
                   <li class="no-padding"><a class="waves-effect waves-grey" href="{{route('logout')}}">Logout</a></li>
                </ul>
                   <div class="footer">
                    
                    <p>Created by cypress24.com</p>
                </div>
                </div>
            </aside>