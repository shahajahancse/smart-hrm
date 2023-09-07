<!-- breadcrumb section -->
<div class="box-widget widget-user-2 container">
    <!-- Add the bg col-md-3or to the header using any of the bg-* classes  -->
    <div class="widget-user-header layout">
        <h4 class="widget-user-username welcome-hrsale-user" style="margin-top:5px;">
            Welcome back, <span style="color:#599AE7 "><?php echo $name->first_name.' '.$name->last_name?></span>
        </h4>
        <div class="breadcrumbs-hr-top">
            <div class="breadcrumb-wrapper col-xs-12">
                <ol class="breadcrumb" style="margin-bottom: 10px; margin-left: -25px; margin-top: -5px;">
                    <li class="breadcrumb-item"><a
                            href="<?php echo site_url('admin/dashboard/');?>"><?php echo $this->lang->line('xin_e_details_home');?></a>
                    </li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>