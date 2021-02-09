<div class="fixed-plugin">
    <div class="dropdown show-dropdown">
        <a href="#" data-toggle="dropdown">
            <i class="fa fa-cog fa-2x"> </i>
        </a>
        <ul class="dropdown-menu">
            <li class="header-title"> Sidebar Background</li>
            <li class="adjustments-line">
                <input type="hidden" name="_token" id="fixed_plugin_token" value="{{ csrf_token() }}">
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors text-center">
                        <span class="badge filter badge-light {{ Auth::user()->side_bg_color == 'white' ? 'active' : '' }} " id="change_bg_to_white" data-color="white" value="white" ></span>
                        <span class="badge filter badge-dark  {{ Auth::user()->side_bg_color == 'black' ? 'active' : '' }} " id="change_bg_to_black" data-color="black" value="black" ></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="header-title"> Sidebar Active Color</li>
            <li class="adjustments-line text-center">
                <a href="javascript:void(0)" class="switch-trigger active-color">
                    <span class="badge filter badge-primary {{ Auth::user()->side_active_color == 'primary' ? 'active' : '' }}" id="change_txt_to_primary" data-color="primary"></span>
                    <span class="badge filter badge-info    {{ Auth::user()->side_active_color == 'info'    ? 'active' : '' }}" id="change_txt_to_info"    data-color="info"></span>
                    <span class="badge filter badge-success {{ Auth::user()->side_active_color == 'success' ? 'active' : '' }}" id="change_txt_to_success" data-color="success"></span>
                    <span class="badge filter badge-warning {{ Auth::user()->side_active_color == 'warning' ? 'active' : '' }}" id="change_txt_to_warning" data-color="warning"></span>
                    <span class="badge filter badge-danger  {{ Auth::user()->side_active_color == 'danger'  ? 'active' : '' }}" id="change_txt_to_danger"  data-color="danger"></span>
                </a>
            </li>
            
        </ul>
    </div>
</div>