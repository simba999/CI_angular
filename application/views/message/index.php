<div ng-controller="MessageController">
    <spinner name="html5spinner" ng-show="html5spinner">  
        <div class="overlay"></div>
        <div class="spinner">
            <img src="<?php echo site_url() ?>assets/loading-icon.gif">  
            <!--                  <div class="double-bounce1"></div>
                              <div class="double-bounce2"></div>-->
        </div>
        <div class="please-wait">Please Wait...</div>
    </spinner>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="page-name message-inbox-head">
                <h1>messages</h1>
                <button class="btn btn-outline-secondary text-uppercase button-sm" data-toggle="modal" data-target="#create-message" ng-click="replyMsg($event)">
                    <i class="fa fa-plus"></i> Message
                </button>								
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="interaction-tabs">
                <ul id="single-ld-interaction" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="nav-item col-sm-6 padding-0">
                        <a href="#inbox-mails" class="nav-link active" aria-controls="profile-stream" role="tab" data-toggle="tab" aria-expanded="true">
                            messages
                        </a>
                    </li>
                    <li role="presentation" class="nav-item col-sm-6 padding-0">
                        <a href="#mass-mails" class="nav-link" aria-controls="profile-photos" role="tab" data-toggle="modal" data-target="#quick-message" aria-expanded="false">
                            Quick Send
                        </a>
                    </li>										
                </ul>
            </div>

            <div class="widget">
                <div class="widget-body">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="inbox-mails" aria-expanded="true">
                            <div class="row">
                                <div class="col-sm-12 msgTypeDropDownInSeDrMSG">
                                    <div class="inbox-operate-lt">
                                        <div class="dropdown mail-operate">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span id="btnText">Inbox</span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="javascript:;" ng-click="getInboxs()">Inbox <span>({{inbox.totalInbox}})</span></a>
                                                <a class="dropdown-item" href="javascript:;" ng-click="getSentbox()">Sent <span>({{inbox.totalSent}})</span></a>
                                                <a class="dropdown-item" href="javascript:;" ng-click="getDraftbox()">Drafts <span>({{inbox.totalDraft}})</span></a>											
                                            </div>
                                        </div>

                                        <a class="refresh-inbox" href="javascript:;">
                                            <i class="fa fa-refresh"></i>
                                        </a>
<!--                                                <a ng-show="loading" class="loading"><img src="<?php //echo site_url() ?>assets/loading.gif"></a>-->
                                    </div>
                                </div>
                            </div>	
                            <div class="row">
                                <div class="col-sm-12 mail-list">
                                    <table class="table" fixed-header>
                                        <thead>
                                            <tr>
                                                <th>
                                        <div class="checkbox">
                                            <input type="checkbox" id="cb-01">
                                            <label for="cb-01"></label>
                                        </div>
                                        </th>
                                        <th></th>															
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Subject</th>
                                        <th ng-show="tdShow">Sent</th>
                                        <th ng-show="tdShow">Opened</th>
                                        <th ng-show="tdShow">Replied</th>
                                        <th ng-show="tdShow">Follow up</th>                                                        
                                        </tr>
                                        </thead>
                                        <tbody ng-if="messageBox == 'inbox'">
                                            <tr ng-repeat="inboxmsg in inbox"  ng-class="{'firstItem': $first}" class="ColorBackOnAct  tr_{{inboxmsg.Id}}" sentMsgAttr="a_{{inboxmsg.Id}}" ng-class-odd="'striped'" >
                                                <td class="select-check widthOfCheck">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="cb-01">
                                                        <label for="cb-01"></label>
                                                    </div>
                                                </td>
                                                <td data-id="{{inboxmsg.Id}}" data-ng-click="showContent($event)">
                                                    <div class="ProfileImageAvatarSpace avatar avatar-circle">
                                                        <a href="javascript:void(0)">
                                                            <img onerror="this.onerror=null;this.src='<?php echo base_url() . ASSETS_DIR . '/no-image-avilable.jpg' ?>';" src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{inboxmsg.ProfileImage}}" alt="avatar">

                                                        </a>
                                                    </div>
                                                </td>
                                                <td data-id="{{inboxmsg.Id}}" ng-click="showContent($event)" class="nameInInboxMsg">{{inboxmsg.FirstName}} {{inboxmsg.LastName}}</td>
                                                <td data-id="{{inboxmsg.Id}}" ng-click="showContent($event)">
                                                {{inboxmsg.CreatedOn}}
                                                </td>
                                                <td data-id="{{inboxmsg.Id}}" ng-click="showContent($event)"><a href="javascript:;">{{inboxmsg.Subject}}</a></td>
                                                <td ng-show="tdShow">{{inboxmsg.sentTimeInHour}}</td>                                                        
                                                <td class="readMsg{{inboxmsg.Id}}" data-msg-id="{{inboxmsg.Id}}" data-read-val="{{inboxmsg.ReadMessage}}" ng-click="readStatus($event)" ng-show="tdShow" ng-if="inboxmsg.ReadMessage === '0'"><i class="fa fa-envelope" style="color: #4e9618" aria-hidden="true"></i></td>
                                                <td class="readMsg{{inboxmsg.Id}}" data-msg-id="{{inboxmsg.Id}}" data-read-val="{{inboxmsg.ReadMessage}}" ng-click="readStatus($event)" ng-show="tdShow" ng-if="inboxmsg.ReadMessage === '1'"><i class="fa fa-envelope" style="color: #c4c4c4" aria-hidden="true"></i></td>

                                                <td data-id="{{inboxmsg.Id}}" ng-click="showContent($event)" ng-show="tdShow" ng-if="inboxmsg.ReplyMessage === '0'"><i class="fa fa-reply" style="color: #4e9618" aria-hidden="true"></i></td>
                                                <td data-id="{{inboxmsg.Id}}" ng-click="showContent($event)" ng-show="tdShow" ng-if="inboxmsg.ReplyMessage === '1'"><i class="fa fa-reply" style="color: #c4c4c4" aria-hidden="true"></i></td>

                                                <td ng-show="tdShow" ng-if="inboxmsg.ReadMessage === '0'">
                                                    <i class="fa fa-reply" style="color: #4e9618;padding: 5px;" aria-hidden="true"></i>
                                                    <i class="fa fa-comment" style="color: #4e9618;padding: 5px;" aria-hidden="true"></i>
                                                    <i class="fa fa-phone" style="color: #4e9618;padding: 5px;" aria-hidden="true"></i>
                                                </td>

                                                <td ng-show="tdShow" ng-if="inboxmsg.ReadMessage === '1'">
                                                    <i class="fa fa-reply" style="color: #c4c4c4;padding: 5px;" aria-hidden="true"></i>
                                                    <i class="fa fa-comment" style="color: #c4c4c4;padding: 5px;" aria-hidden="true"></i>
                                                    <i class="fa fa-phone" style="color: #c4c4c4;padding: 5px;" aria-hidden="true"></i>
                                                </td>
                                            </tr>
                                            <tr ng-if="inbox.totalInbox == 0">
                                                <td colspan="9">No mail found.</td>
                                            </tr>
                                        </tbody>

                                        <tbody ng-if="messageBox == 'sentbox'">
                                            <tr ng-repeat="sentboxmsg in sentbox" ng-class="{'firstItem': $first}" class="ColorBackOnAct  tr_{{sentboxmsg.Id}}" sentMsgAttr="a_{{sentboxmsg.Id}}" ng-class-odd="'striped'">
                                                <td class="select-check widthOfCheck">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="cb-01">
                                                        <label for="cb-01"></label>
                                                    </div>
                                                </td>
                                                <td data-id="{{sentboxmsg.Id}}" ng-click="showContent($event)">
                                                    <div class="ProfileImageAvatarSpace avatar avatar-circle">
                                                        <a href="javascript:void(0)">
                                                            <img onerror="this.onerror=null;this.src='<?php echo base_url() . ASSETS_DIR . '/no-image-avilable.jpg' ?>';" src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{sentboxmsg.RecProfImg}}" alt="avatar">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td data-id="{{sentboxmsg.Id}}" ng-click="showContent($event)">{{sentboxmsg.RecFirNam}} {{sentboxmsg.RecLasNam}}</td>
                                                <td data-id="{{sentboxmsg.Id}}" ng-click="showContent($event)">{{sentboxmsg.CreatedOn}}</td>
                                                <td data-id="{{sentboxmsg.Id}}" ng-click="showContent($event)"><a href="javascript:;"> {{sentboxmsg.Subject}}</a></td>

                                                <td data-id="{{sentboxmsg.Id}}" ng-show="tdShow"><a href="javascript:;"> {{sentboxmsg.sentTime}}</a></td>                                                       
                                                <td ng-show="tdShow"></td>                                                        
                                                <td ng-show="tdShow"><i class="fa fa-reply" style="color: #4e9618" aria-hidden="true"></i></td>                                                        
                                                <td ng-show="tdShow">
                                                    <i class="fa fa-reply" style="color: #4e9618;padding: 5px;" aria-hidden="true"></i>
                                                    <i class="fa fa-comment" style="color: #4e9618;padding: 5px;" aria-hidden="true"></i>
                                                    <i class="fa fa-phone" style="color: #4e9618;padding: 5px;" aria-hidden="true"></i>
                                                </td>
                                            </tr>
                                            <tr ng-if="inbox.totalSent == 0">
                                                <td colspan="9">No mail found.</td>
                                            </tr>

                                        </tbody>
                                        <tbody ng-if="messageBox == 'draft'">
                                            <tr ng-repeat="draftmsg in draft" ng-class="{'firstItem': $first}" class="ColorBackOnAct  tr_{{draftmsg.Id}}{{$index}}" sentMsgAttr="a_{{draftmsg.Id}}{{$index}}" ng-class-odd="'striped'">
                                                <td class="select-check">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="cb-01">
                                                        <label for="cb-01"></label>
                                                    </div>
                                                </td>
                                                <td data-id="{{draftmsg.Id}}{{$index}}" ng-click="showContent($event)" >
                                                    <div class="avatar avatar-circle">
                                                        <a href="javascript:void(0)">
                                                            <img onerror="this.onerror=null;this.src='<?php echo base_url() . ASSETS_DIR . '/no-image-avilable.jpg' ?>';" src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{draftmsg.ProfileImage}}" alt="avatar">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td data-id="{{draftmsg.Id}}{{$index}}" ng-click="showContent($event)"  width="50%">
                                                    {{draftmsg.FirstName}} {{draftmsg.LastName}}

                                                </td>
                                                <td data-id="{{draftmsg.Id}}{{$index}}" ng-click="showContent($event)"  width="30%" >
                                                    {{draftmsg.CreatedOn}}
                                                </td>
                                                <td data-id="{{draftmsg.Id}}{{$index}}" ng-click="showContent($event)" >
                                                    <a href="javascript:;"> {{draftmsg.Subject}}</a>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td ng-show="tdShow"><i class="fa fa-reply" style="color: #4e9618" aria-hidden="true"></i></td>                                                        
                                                <td ng-show="tdShow">
                                                    <i class="fa fa-reply" style="color: #4e9618;padding: 5px;" aria-hidden="true"></i>
                                                    <i class="fa fa-comment" style="color: #4e9618;padding: 5px;" aria-hidden="true"></i>
                                                    <i class="fa fa-phone" style="color: #4e9618;padding: 5px;" aria-hidden="true"></i>
                                                </td>
                                            </tr>
                                            <tr ng-if="inbox.totalDraft == 0">
                                                <td colspan="9">No mail found.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Inbox : Start -->
                                <div ng-repeat="inboxmsg in inbox"  class="col-sm-6 actOnPopup dis_{{inboxmsg.Id}} pull-right messageInboxClass" ng-if = "showContentData == true">

                                    <div class="follow-up-title">
                                        <h6>{{inboxmsg.Subject}} <span ng-click="hideContent();" class="pull-right"><i class="fa fa-remove"></i></span></h6>
                                    </div>

                                    <div class="follow-up-content">
                                        <div class="media stream-post">
                                            <div class="avatar avatar-circle">
                                                <!-- <img src="assets/global/images/221.jpg" alt="avatar"> -->
                                                <img onerror="this.onerror=null;this.src='<?php echo base_url() . ASSETS_DIR . '/no-image-avilable.jpg' ?>';" src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{inboxmsg.ProfileImage}}" alt="avatar">
                                            </div>
                                            <div class="media-body">
                                                <div class="follow-up-name">
                                                    <h4 class="media-heading mt-1">
                                                        <a href="javascript:;" class="sp-auther" data-toggle="tooltip" title="{{inboxmsg.From}}"> {{inboxmsg.FirstName}} {{inboxmsg.LastName}}
                                                        </a> 
                                                    </h4>
													<small class="sp-meta">From : {{inboxmsg.FirstName}} <i class="fa fa-address-card addressCardDesign" aria-hidden="true"></i> {{ inboxmsg.sentTimeInHour }}</small>
                                                </div>

                                                <div class="follow-up-rply">
                                                    <div class="btn-group list-view-style" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#create-message" id="reply{{inboxmsg.Id}}" ng-click="replyMsg($event)" data-reply-status="{{inboxmsg.ReplyMessage}}" data-parent-id="{{inboxmsg.threadId}}"><i class="fa fa-reply green"></i></button>                                
                                                        <button type="button" class="btn btn-outline-secondary"><i class="fa fa-angle-down"></i></button>
                                                    </div>
                                                </div>

                                                <div class="sp-content">
                                                    <p ng-bind-html = "inboxmsg.Content | unsafe | limitTo : 20 "> </p>                                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Inbox: End -->

                                <div ng-repeat="sentboxmsg in sentbox" class="col-sm-6 actOnPopup dis_{{sentboxmsg.Id}}"  ng-if = "showContentData == true">

                                    <div class="follow-up-title">
                                        <h6>{{sentboxmsg.Subject}}<span ng-click="hideContent();" class="pull-right"><i class="fa fa-remove"></i></span></h6>
                                    </div>

                                    <div class="follow-up-content">
                                        <div class="media stream-post">
                                            <div class="avatar avatar-circle">
                                                <img onerror="this.onerror=null;this.src='<?php echo base_url() . ASSETS_DIR . '/no-image-avilable.jpg' ?>';" src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{sentboxmsg.RecProfImg}}" alt="avatar">
                                            </div>
                                            <div class="media-body">
                                                <div class="follow-up-name">
                                                    <h4 class="media-heading mt-1">
                                                        <a href="javascript:;" class="sp-auther" data-toggle="tooltip" title="{{inboxmsg.To}}"> {{sentboxmsg.RecFirNam}} {{sentboxmsg.RecLasNam}}
                                                        </a> 
                                                    </h4>
                                                    <!--<small class="sp-meta">Job Description/Job Position</small>--><small class="sp-meta">To : <?php echo !empty($this->session->userData("user_fullname"))?$this->session->userData("user_fullname"):''; ?> <i class="fa fa-address-card addressCardDesign" aria-hidden="true"></i> <?php echo date("H:i A"); ?></small>
                                                </div>

                                                <div class="follow-up-rply">
                                                    <div class="btn-group list-view-style" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-outline-secondary"><i class="fa fa-reply green"></i></button>								  
                                                        <button type="button" class="btn btn-outline-secondary"><i class="fa fa-angle-down"></i></button>
                                                    </div>
                                                </div>

                                                <div class="sp-content">
                                                    <p ng-bind-html = "sentboxmsg.Content | unsafe | limitTo : 20 "> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div ng-repeat="draftmsg in draft" class="col-sm-6 actOnPopup dis_{{draftmsg.Id}}{{$index}}" ng-if = "showContentData == true">
                                    <div class="follow-up-title">
                                        <h6>{{draftmsg.Subject}}<span ng-click="hideContent();" class="pull-right"><i class="fa fa-remove"></i></span></h6>
                                    </div>
                                    <div class="follow-up-content">
                                        <div class="media stream-post">
                                            <div class="avatar avatar-circle">
                                                <img onerror="this.onerror=null;this.src='<?php echo base_url() . ASSETS_DIR . '/no-image-avilable.jpg' ?>';" src="<?php echo base_url() . UPLOAD_DIR . "/" . IMAGE . "/" . USER_IMAGE . "/" ?>{{draftmsg.ProfileImage}}" alt="avatar">
                                            </div>
                                            <div class="media-body">
                                                <div class="follow-up-name">
                                                    <h4 class="media-heading mt-1">
                                                        <a href="javascript:;" class="sp-auther" data-toggle="tooltip" title="{{inboxmsg.To}}"> {{draftmsg.FirstName}} {{draftmsg.LastName}}
                                                        </a>
                                                    </h4>
                                                    <!--<small class="sp-meta">Job Description/Job Position</small>--><small class="sp-meta">From : <?php echo !empty($this->session->userData("user_fullname"))?$this->session->userData("user_fullname"):''; ?> <i class="fa fa-address-card addressCardDesign" aria-hidden="true"></i> <?php echo date("H:i A"); ?></small>
                                                </div>
                                                <div class="follow-up-rply">
                                                    <div class="btn-group list-view-style" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-outline-secondary"><i class="fa fa-reply green"></i></button>
                                                        <button type="button" class="btn btn-outline-secondary"><i class="fa fa-angle-down"></i></button>
                                                    </div>
                                                </div>

                                                <div class="sp-content">
                                                    <p ng-bind-html = "draftmsg.Content | unsafe | limitTo : 20 "> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane active" id="mass-mails" aria-expanded="true">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- </div>                
 
          .site-content -->
        <!-- </main> -->
        <?php $this->load->view('message/particals/create_message'); ?>
        <?php $this->load->view('message/particals/quicksend_message'); ?>
    </div>

</div>
<?php $this->load->view('components/footer'); ?>
<script src="<?php echo base_url() ?>app/controllers/MessageController.js"></script>
<style>
/*    .table{
        height:500px;
    }*/
    .help-block{
        color:#f00;
    }
    .striped{
        background: #EFEFEF;
    }
    .pac-container {
        z-index: 10000 !important;
    }
    .bgCol{
        background-color: #F7E48E;
    }
    tr.ColorBackOnAct:active{ 
        background-color: #F7E48E;
    }
    .firstItem{
        background-color: #F7E48E;   
    }
    #myDIV {
        width: 100%;
        padding: 0px 0;
        text-align: left;
        background-color: #ffffff;
        margin-top: 0px;
    }
    .mail-list table tbody tr td  a {
        border-bottom: 1px solid #cfcfcf;
        color: #4e961a;
        font-family: 'Lato';
        font-weight: 400;
    }
    .ColorForLink{
        color: #4e961a !important;
    }
    .bgdemocol{
        background-color: #F7E48E;   
    }

    /* for loader*/
    body {
        background-color: #777;
        /*  padding-top: 15px;*/
    }

    .spinner img{
        /*    width: 100%;
            height: 100%;
            opacity: 0.6;*/
        position: absolute;
        top: 0;
        left: 0;
        z-index: 10;
    }
    .double-bounce1, .double-bounce2 {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #9c9;
        border: solid 3px #fff;
        opacity: 0.6;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 10;

        -webkit-animation: bounce 2.0s infinite ease-in-out;
        animation: bounce 2.0s infinite ease-in-out;
    }

    .double-bounce2 {
        -webkit-animation-delay: -1.0s;
        animation-delay: -1.0s;
    }

    @-webkit-keyframes bounce {
        0%, 100% { -webkit-transform: scale(0.0) }
        50% { -webkit-transform: scale(1.0) }
    }

    @keyframes bounce {
        0%, 100% { 
            transform: scale(0.0);
            -webkit-transform: scale(0.0);
        } 50% { 
            transform: scale(1.0);
            -webkit-transform: scale(1.0);
        }
    }

    form.well {
        position: relative;
    }

    .overlay {
        opacity: .50;
        background-color: #000;
        width: calc(100% + 2px);
        height: calc(100% + 2px);
        position: absolute;
        z-index: 5;
        margin: -20px -20px;
        border-radius: 3px;
    }
    .spinner {
        width: 100px;
        height: 100px;
        position: absolute;
        top: 4%; /*calc(30% - 70px);*/
        left:27%; /* calc(55% - 50px);*/
    }
    .please-wait {
        text-align: center;
        position: absolute;
        top:34%;/* calc(30% + 20px);*/
        left:50%;/* calc(55% - 50px);*/
        color: #fff;
        z-index: 10;
    }
     /*@media only screen and (min-width: 375px) and (min-height: 667px) {
        .spinner {
            width: 100px;
            height: 100px;
            position: absolute;
            top: 0%; 
            right:13%;
            left:-55%;
        }
    }
    @media only screen and (min-width: 375px) and (min-height: 667px) {
        .please-wait {
            text-align: center;
            position: absolute;
            top:30%;
            right:5%;
            left:8%;
            color: #fff;
            z-index: 10;
        }
    }
    @media only screen and (min-width: 414px)  and (min-height: 736px){
        .spinner {
            width: 100px;
            height: 100px;
            position: absolute;
            top: 3%;
            right:10%;
            left:-45% ;
        }
    }
    @media only screen and (min-width: 414px) and (min-height: 736px) {
        .please-wait {
            text-align: center;
            position: absolute;
            top:33%;
            right:5%;
            left:7%;
            color: #fff;
            z-index: 10;
        }
    }
    @media only screen and (max-width: 1024px) and  (min-width: 1024px) and (min-height: 1366px) and (max-height: 1366px) {
        .spinner {
            width: 100px;
            height: 100px;
            position: absolute;
            top:23%; 
            right:0%; 
            left:17%;
        }
    }
    @media only screen and (max-width: 1024px) and (min-width: 1024px) and (min-height: 1366px) and (max-height: 1366px) {
        .please-wait {
            text-align: center;
            position: absolute;
            top:25%;
            left:45%;
            color: #fff;
            z-index: 10;
        }
    }
    @media only screen and (min-width: 1280px) and (min-height: 1024px){
        .spinner {
            width: 100px;
            height: 100px;
            position: absolute;
            top: 14%;
            left:22%; 
        }
    }
    @media only screen and (min-width: 1280px) and (min-height: 1024px) {
        .please-wait {
            text-align: center;
            position: absolute;
            top:43.5%;
            left:50%;
            color: #fff;
            z-index: 10;
        }
    }
    @media only screen and (max-width: 375px) and  (min-width: 375px) and (min-height: 812px) and (max-height: 812px) {
        .spinner {
            width: 100px;
            height: 100px;
            position: absolute;
            top:5%; 
            right:13%;
            left:-55%;
        }
    }
    @media only screen and (max-width: 375px) and  (min-width: 375px) and (min-height: 812px) and (max-height: 812px) {
        .please-wait {
            text-align: center;
            position: absolute;
            top:35%;
            right:5%;
            left:7%;
            color: #fff;
            z-index: 10;
        }
    }
    @media only screen and (max-width: 768px) and (min-height: 1024px) and (min-width: 768px) and (max-height: 1024px) {
        .spinner {
            width: 100px;
            height: 100px;
            position: absolute;
            top: 15%; 
            right:13%; 
            left:0%;
        }
    }
    @media only screen and (min-width: 768px) and (min-height: 1024px) and (max-width: 768px) and (max-height: 1024px) {
        .please-wait {
            text-align: center;
            position: absolute;
            top:45%;
            right:5%;
            left:8%;
            color: #fff;
            z-index: 10;
        }
    }*/
    /*@media only screen and (min-width: 1024px) {
        .spinner {
            width: 100px;
            height: 100px;
            position: absolute;
            top: 25%; /*calc(30% - 70px);
            left:20%;
        }
    }
    @media only screen and (min-width: 1024px) {
        .please-wait {
            text-align: center;
            position: absolute;
            top:53%;/* calc(30% + 20px);
            right:5%; /* calc(55% - 50px);
            left:22%;/* calc(55% - 50px);
            color: #fff;
            z-index: 10;
        }
    }*/
    .success {
        padding: 15px;
        text-align: center;
        border-radius: 50%;
        border: solid 2px #050;
    }

    .glyphicon-remove {
        cursor: pointer;
    }

</style>
<script>
                                                        /*$(".bgdemocol").css("background-color",'green');*/
                                                        $(document).on("click", ".ColorBackOnAct", function () {
                                                            var attrVal = $(this).attr("sentMsgAttr");
                                                            var classVal = attrVal.split("_");
                                                            /*$(".actOnPopup").hide();*/
                                                            $('.ColorBackOnAct').removeClass("bgCol");
                                                            $('.ColorBackOnAct').removeClass("firstItem");
                                                            $('.tr_' + classVal[1]).addClass("bgCol");
                                                            $(".dis_" + classVal[1]).show();
                                                            $(".actOnPopup").addClass("ng-hide");
                                                            $(".dis_" + classVal[1]).removeClass("ng-hide");
                                                            /*console.labelog($(".dis_"+classVal[1]).show());*/
                                                        });

                                                        /*var queryResult = element[0].querySelector('.multi-files');*/
                                                        $('.modal').on('hidden.bs.modal', function () {

                                                            $(this).find('form')[0].reset();
                                                        });
                                                        $(document).ready(function () {

                                                            $('#messageContent').summernote();
                                                        });

</script>
