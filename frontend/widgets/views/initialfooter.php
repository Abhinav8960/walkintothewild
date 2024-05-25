<?php
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<footer class="main_footer position-relative">
  <div class="footer_object">
  <img src="<?= $this->params['baseurl'] ?>/img/desktopfooter.png" alt="" class="d-md-block d-none">
        <img src="<?= $this->params['baseurl'] ?>/img/footermobile.png" alt="" class="d-md-none d-block">
  </div>
  <div class="container-fluid">
    <div class="row  border_bottom soon_pagefooter">
      <div class="col-xxl-4 col-lg-6 col-md-6 pb-lg-0 pb-5">
        <div class="footer_text ">
          <div class="heading-footer">
            <h6>Contact </h6>
          </div>
          <div class="footerContent">
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <div class="comingsoonpage-footer d-flex align-items-center gap-2">
                <div class="insticon"><i class="fa-brands fa-instagram"></i> </div>
                <a href="">walkintothewild.in</a>
              </div>
              <span class="d-sm-block d-none">|</span>
              <div class="comingsoonpage-footer">
                <p class="mb-0"><strong>Email:</strong> <a href="mailto:contact@walkintothewild.in">contact@walkintothewild.in</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xxl-5 col-lg-6 col-md-6 pb-lg-0 pb-4">
        <div class="footer_text ">
          <div class="heading-footer">
            <h6>BECOME A PARTNER </h6>
          </div>
          <div class="footerContent">
            <ul class="footer_listing d-flex gap-md-3 gap-2 flex-wrap">
              <li><a href="">Safari Tour Operator</a></li>
              <li>|</li>
              <li><a href="">Birding Tour Operator</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-xxl-3 col-lg-6  col-md-6 pb-lg-0 pb-4">
        <div class="footer_text float-xxl-end">
          <div class="heading-footer">
            <h6>LEGAL</h6>
          </div>
          <div class="footerContent legal">
            <ul class="footer_listing d-flex gap-2">
              <li><a href="" data-bs-toggle="modal" data-bs-target="#modalTermscondition">TERMS & CONDITIONS</a></li>
              <li>|</li>
              <li><a href="" data-bs-toggle="modal" data-bs-target="#modalprivacyPolicy">PRIVACY POLICY</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="row pt-4 justify-content-between mobile-responsive align-items-center">
      <div class="col-lg-2 col-md-4">
        <div class="footerlogo">
          <img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="" width="160">
        </div>
      </div>
      <div class="col-lg-0 col-md-8">
        <div class="copyright float-lg-end">
          <p>COPYRIGHT © 2024 | WALK INTO THE WILD | ALL RIGHTS RESERVED</p>
        </div>
      </div>

    </div>
  </div>
</footer>
<div class="modal fade" id="modalTermscondition" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">TERMS & CONDITIONS</h1>
        <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body modal_form">
        <div class="terms_details">
          <h6 class=" pb-3">By accessing, using, or signing up for this website, newsletters, or any services, you enter into a legally binding agreement with Walk Into The Wild based on these terms.</h6>

          <h6>Introduction</h6>
          <p>Welcome to the <a href="https://www.walkintothewild.in/" target="_blank">www.walkintothewild.in</a> website ("Website", "website", "Site" or "site"). This website, its pages, the content, services, and infrastructure are owned, operated, and provided by Walk Into The Wild ("Walk Into The Wild", "Us", "us", "We" or "we") or other parties. The website and its content are provided for your personal, non-commercial use only, subject to the terms of use as set out below. These terms of use (this "Agreement") set forth the terms and conditions governing your use of this website.</p>
          <h6>Modifications to this Agreement</h6>
          <p>We reserve the right to modify this Agreement at our sole discretion. Changes are effective immediately upon updating this page. Please review this Agreement periodically. By continuing to use our website after changes are made, you accept those changes.</p>
          <h6>Privacy</h6>
          <p>We outline our current practices regarding personally identifiable and other information collected through our website in our Privacy Policy. We reserve the right to update our policies and practices at our sole discretion. By using our website, you acknowledge that you have read and agree to our privacy policy.</p>
          <h6>Your use of content and information (disclaimer)</h6>
          <p>We offer a diverse range of content on our website, including information, advice, recommendations, messages, comments, posts, text, graphics, software, music, sound, photographs, videos, data, and other materials ("Content" or "content"). Some content is provided by us or our suppliers, while other content is contributed by users of our website ("Users" or "users"), such as opinions and views shared via reviews, chat rooms, blogs, or message boards. While we strive to ensure the accuracy, completeness, and timeliness of the content on our website, we cannot guarantee it and are not responsible for any inaccuracies, omissions, or delays, whether in content provided by us, our suppliers, or users. Any opinions, advice, statements, or other information expressed by users or third parties are solely their own and do not represent our views.</p>
          <p>We are not obligated to prescreen, edit, or remove any user-provided content posted on or available through our website. However, we reserve the right (but not the obligation), at our sole discretion and for any reason, to prescreen, edit, refuse, remove, or relocate any such content.</p>
          <h6>User generated content</h6>
          <p>User-generated content ("User Content" or "user content") refers to information provided by our users with the intention of being published on our website (e.g., writing a review or posting on our boards). As a user of our website, you assume responsibility for all user content that you submit, post, or otherwise make available through our platform.</p>
          <p>While we do not claim ownership of user content, by submitting, posting, or otherwise making content available through our website, you automatically grant us the right to utilize your user content as we see fit. This includes the non-exclusive, perpetual, transferable, irrevocable right, with the right of sublicensing, and without any royalty or compensation in return, to use, reproduce, modify, translate, distribute, publish, create derivative works, disclose, and duplicate the content across all known and future media. You acknowledge that we may determine how your user content is credited and accept that the content provided may be indexed by search engines such as Google. Additionally, you grant us and any third party appointed by us the right to take legal actions deemed necessary for the protection of the rights of your user content, including, but not limited to, taking legal action on your behalf.</p>
          <p>You agree not to submit, post, or otherwise make available through our website any personally identifiable information about other people or any abusive, obscene, vulgar, slanderous, hateful, threatening, sexually-oriented user content, or any other material that may violate any laws, whether of your country, the Indian, any other country, or international law. You confirm that such user content is not confidential and that you have all necessary permissions to submit, post, and otherwise make available such user content. Moreover, you undertake not to submit, post, or otherwise make available through our website any commercial, advertising, promotional, or spam-like user content. Violation of any of these conditions may lead to immediate and permanent banning, with notification to your Internet Service Provider if deemed necessary by us, and we reserve the right to take other legal action. You agree that we have the discretion to remove, edit, move, or close your account and/or any user content at any time as we deem appropriate.</p>
         
          <h6>Ownership and Intellectual property rights</h6>
          <p>This website is owned by Walk Into The Wild. All rights and interest in the content available via the website, the website's look and feel, the designs, trademarks, service marks, and trade names displayed on the website, and the website URL are the property of Walk Into The Wild or its licensors, and are protected by copyrights, trademarks, patents, or other proprietary rights and laws. You may not use any content available via the website in any manner or for any purpose without the prior written permission of us or, if applicable, our licensors. All rights not expressly granted in this Agreement are expressly reserved to Walk Into The Wild and its licensors.</p>
          <h6>Your contact with advertisers or other third parties</h6>
          <p>Your interactions with advertisers or other third parties found on or accessible through our website are exclusively between you and the third party. These interactions encompass, but are not limited to, your engagement in promotions, the payment for and receipt of items such as safari tours, if any, and any terms, conditions, warranties, or representations associated with such transactions. Your access and use of such sites, including the content, items, or services offered on those sites, is solely at your own risk. We do not provide any assurances or guarantees regarding the content or privacy practices of such third parties, or otherwise concerning the services or items provided by them. By using our website, you acknowledge and agree that we bear no responsibility for any loss or damage of any nature arising from your dealings with any third party or their presence on our website.</p>
          <h6>Disclaimer of warranties</h6>
          <p>THE WEBSITE IS PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS. WALK INTO THE WILD EXPRESSLY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, WITHOUT LIMITATION, ANY WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NONINFRINGEMENT. WALK INTO THE WILD DOES NOT MAKE ANY WARRANTY THAT THE WEBSITE WILL MEET YOUR REQUIREMENTS, OR THAT ACCESS TO THE WEBSITE WILL BE UNINTERRUPTED, TIMELY, SECURE, OR ERROR-FREE, OR THAT DEFECTS, IF ANY, WILL BE CORRECTED. WALK INTO THE WILD MAKES NO WARRANTIES AS TO THE RESULTS THAT MAY BE OBTAINED FROM THE USE OF THE WEBSITE OR AS TO THE ACCURACY, QUALITY, OR RELIABILITY OF ANY INFORMATION OBTAINED THROUGH THE WEBSITE.</p>
          <h6>Disclaimer of warranties</h6>
          <p>WALK INTO THE WILD AND ITS AFFILIATES ASSUME NO RESPONSIBILITY FOR ANY CONSEQUENCES DIRECTLY OR INDIRECTLY RELATED TO ANY ACTION OR INACTION YOU TAKE BASED ON THE CONTENT AVAILABLE VIA THE WEBSITE. YOU MUST ASSESS AND BEAR ALL RISKS ASSOCIATED WITH THE USE OF ANY CONTENT, INCLUDING ANY RELIANCE ON THE ACCURACY, COMPLETENESS, OR USEFULNESS OF SUCH CONTENT. YOU SPECIFICALLY ACKNOWLEDGE THAT WALK INTO THE WILD IS NOT LIABLE FOR THE DEFAMATORY, OFFENSIVE, OR ILLEGAL CONDUCT OF USERS OR THIRD PARTIES.</p>
          <p>ADDITIONALLY, IN NO EVENT WILL WALK INTO THE WILD OR ITS AFFILIATES BE LIABLE FOR ANY SPECIAL, INDIRECT, INCIDENTAL, PUNITIVE, OR CONSEQUENTIAL DAMAGES, INCLUDING, WITHOUT LIMITATION, ANY LOSS OF USE, LOSS OF PROFITS, LOSS OF DATA, COST OF PROCUREMENT OF SUBSTITUTE PRODUCTS OR SERVICES, OR ANY OTHER SUCH DAMAGES, HOWSOEVER CAUSED, AND ON ANY THEORY OF LIABILITY, WHETHER FOR BREACH OF CONTRACT, TORT (INCLUDING NEGLIGENCE AND STRICT LIABILITY), OR OTHERWISE RESULTING FROM (1) THE USE OF, OR THE INABILITY TO USE THE WEBSITE; (2) THE COST OF PROCUREMENT OF SUBSTITUTE SERVICES, ITEMS, OR WEBSITES; (3) UNAUTHORIZED ACCESS TO OR ALTERATION OF YOUR TRANSMISSIONS OR DATA; (4) THE STATEMENTS OR CONDUCT OF ANY THIRD PARTY ON THE WEBSITE; OR (5) ANY OTHER MATTER RELATING TO THE WEBSITE. THESE LIMITATIONS WILL APPLY WHETHER OR NOT WALK INTO THE WILD HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES AND NOTWITHSTANDING ANY FAILURE OF THE ESSENTIAL PURPOSE OF ANY LIMITED REMEDY.</p>
          </p>
          <h6>Indemnification</h6>
          <p>You agree to indemnify and hold harmless Walk Into The Wild, its directors, officers, employees, owners, agents, and affiliates, from and against any and all liability, damages, losses, claims, and expenses of any kind (including, without limitation, reasonable attorneys' fees) directly or indirectly related to (1) your breach of the Agreement; or (2) the user content you submit, post, or transmit through the website.</p>
          
          <h6>Your account</h6>
          <p>You are accountable for safeguarding the confidentiality of any passwords linked to your account on our website, monitoring all activity under the account, and taking full responsibility for all actions occurring under your account.</p>
          
          <h6>Modification or suspension of our website</h6>
          <p>We may at any time modify, discontinue, or suspend the operation of our website, or any part thereof, temporarily or permanently, without notice to you. </p>
          
          <h6>Change of ownership</h6>
          <p>If we are in the process of selling Walk Into The Wild, our website, or substantial parts of our business, you agree we may disclose and/or transfer your personally identifiable information as well as other information to the (potential) new owner so they can better value our business and, if sold, continue to operate the service this website provides. This will also be the case if the new owner is a non-EU company, organization, or individual.</p>
          <p>You also agree that in the event of a change in ownership of Walk Into The Wild or our website, the rights, obligations, and restrictions you have towards us, as outlined in this agreement, will be transferred to the new owner without notice to you, and you accept the new owner as your new counterparty in this Agreement.</p>
          <h6>Termination of this Agreement</h6>
          <p>Either party may terminate the Agreement for any reason or without cause, at any time, by notice, which shall be effective immediately or as specified in the notice. After termination, you shall no longer access Walk Into The Wild's website. The provisions of this Agreement which, by their intent or meaning, are intended to survive such termination shall continue to apply indefinitely.</p>
          <h6>Severability of Agreement</h6>
          <p>If any provision of the Agreement is deemed invalid by a court or other binding authority, you agree that every effort shall be made to uphold the parties' intentions as reflected in that provision. The remaining provisions of the Agreement, which are not affected by such invalidity, shall remain in full force and effect.</p>
          <h6>Complaints regarding content</h6>
          <p>For making complaints regarding copyright infringement of our content or regarding our content in general, please send an email to <a href="mailto:contact@walkintothewild.in">contact@walkintothewild.in</a></p>

          
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="modalprivacyPolicy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">PRIVACY POLICY</h1>
        <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body modal_form">
        <div class="title_terms text-center">
          <h5>PRIVACY POLICY</h5>
        </div>
        <div class="terms_details">
          <h6 class=" pb-3">By accessing, using, or signing up for this website, newsletters, or any services, you enter into a legally binding agreement with Walk Into The Wild based on these terms.</h6>

          <h6>Introduction</h6>
          <p>Welcome to the <a href="https://www.walkintothewild.in/" target="_blank">www.walkintothewild.in</a> website ("Website", "website", "Site" or "site"). This website, its pages, the content, services, and infrastructure are owned, operated, and provided by Walk Into The Wild ("Walk Into The Wild", "Us", "us", "We" or "we") or other parties. The website and its content are provided for your personal, non-commercial use only, subject to the terms of use as set out below. These terms of use (this "Agreement") set forth the terms and conditions governing your use of this website.</p>
          <h6>Modifications to this Agreement</h6>
          <p>We reserve the right to modify this Agreement at our sole discretion. Changes are effective immediately upon updating this page. Please review this Agreement periodically. By continuing to use our website after changes are made, you accept those changes.</p>
          <h6>Privacy</h6>
          <p>We outline our current practices regarding personally identifiable and other information collected through our website in our Privacy Policy. We reserve the right to update our policies and practices at our sole discretion. By using our website, you acknowledge that you have read and agree to our privacy policy.</p>
          <h6>Your use of content and information (disclaimer)</h6>
          <p>We offer a diverse range of content on our website, including information, advice, recommendations, messages, comments, posts, text, graphics, software, music, sound, photographs, videos, data, and other materials ("Content" or "content"). Some content is provided by us or our suppliers, while other content is contributed by users of our website ("Users" or "users"), such as opinions and views shared via reviews, chat rooms, blogs, or message boards. While we strive to ensure the accuracy, completeness, and timeliness of the content on our website, we cannot guarantee it and are not responsible for any inaccuracies, omissions, or delays, whether in content provided by us, our suppliers, or users. Any opinions, advice, statements, or other information expressed by users or third parties are solely their own and do not represent our views.</p>
          <p>We are not obligated to prescreen, edit, or remove any user-provided content posted on or available through our website. However, we reserve the right (but not the obligation), at our sole discretion and for any reason, to prescreen, edit, refuse, remove, or relocate any such content.</p>
          <h6>User generated content</h6>
          <p>User-generated content ("User Content" or "user content") refers to information provided by our users with the intention of being published on our website (e.g., writing a review or posting on our boards). As a user of our website, you assume responsibility for all user content that you submit, post, or otherwise make available through our platform.</p>
          <p>While we do not claim ownership of user content, by submitting, posting, or otherwise making content available through our website, you automatically grant us the right to utilize your user content as we see fit. This includes the non-exclusive, perpetual, transferable, irrevocable right, with the right of sublicensing, and without any royalty or compensation in return, to use, reproduce, modify, translate, distribute, publish, create derivative works, disclose, and duplicate the content across all known and future media. You acknowledge that we may determine how your user content is credited and accept that the content provided may be indexed by search engines such as Google. Additionally, you grant us and any third party appointed by us the right to take legal actions deemed necessary for the protection of the rights of your user content, including, but not limited to, taking legal action on your behalf.</p>
          <p>You agree not to submit, post, or otherwise make available through our website any personally identifiable information about other people or any abusive, obscene, vulgar, slanderous, hateful, threatening, sexually-oriented user content, or any other material that may violate any laws, whether of your country, the Indian, any other country, or international law. You confirm that such user content is not confidential and that you have all necessary permissions to submit, post, and otherwise make available such user content. Moreover, you undertake not to submit, post, or otherwise make available through our website any commercial, advertising, promotional, or spam-like user content. Violation of any of these conditions may lead to immediate and permanent banning, with notification to your Internet Service Provider if deemed necessary by us, and we reserve the right to take other legal action. You agree that we have the discretion to remove, edit, move, or close your account and/or any user content at any time as we deem appropriate.</p>
         
          <h6>Ownership and Intellectual property rights</h6>
          <p>This website is owned by Walk Into The Wild. All rights and interest in the content available via the website, the website's look and feel, the designs, trademarks, service marks, and trade names displayed on the website, and the website URL are the property of Walk Into The Wild or its licensors, and are protected by copyrights, trademarks, patents, or other proprietary rights and laws. You may not use any content available via the website in any manner or for any purpose without the prior written permission of us or, if applicable, our licensors. All rights not expressly granted in this Agreement are expressly reserved to Walk Into The Wild and its licensors.</p>
          <h6>Your contact with advertisers or other third parties</h6>
          <p>Your interactions with advertisers or other third parties found on or accessible through our website are exclusively between you and the third party. These interactions encompass, but are not limited to, your engagement in promotions, the payment for and receipt of items such as safari tours, if any, and any terms, conditions, warranties, or representations associated with such transactions. Your access and use of such sites, including the content, items, or services offered on those sites, is solely at your own risk. We do not provide any assurances or guarantees regarding the content or privacy practices of such third parties, or otherwise concerning the services or items provided by them. By using our website, you acknowledge and agree that we bear no responsibility for any loss or damage of any nature arising from your dealings with any third party or their presence on our website.</p>
          <h6>Disclaimer of warranties</h6>
          <p>THE WEBSITE IS PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS. WALK INTO THE WILD EXPRESSLY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, WITHOUT LIMITATION, ANY WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NONINFRINGEMENT. WALK INTO THE WILD DOES NOT MAKE ANY WARRANTY THAT THE WEBSITE WILL MEET YOUR REQUIREMENTS, OR THAT ACCESS TO THE WEBSITE WILL BE UNINTERRUPTED, TIMELY, SECURE, OR ERROR-FREE, OR THAT DEFECTS, IF ANY, WILL BE CORRECTED. WALK INTO THE WILD MAKES NO WARRANTIES AS TO THE RESULTS THAT MAY BE OBTAINED FROM THE USE OF THE WEBSITE OR AS TO THE ACCURACY, QUALITY, OR RELIABILITY OF ANY INFORMATION OBTAINED THROUGH THE WEBSITE.</p>
          <h6>Disclaimer of warranties</h6>
          <p>WALK INTO THE WILD AND ITS AFFILIATES ASSUME NO RESPONSIBILITY FOR ANY CONSEQUENCES DIRECTLY OR INDIRECTLY RELATED TO ANY ACTION OR INACTION YOU TAKE BASED ON THE CONTENT AVAILABLE VIA THE WEBSITE. YOU MUST ASSESS AND BEAR ALL RISKS ASSOCIATED WITH THE USE OF ANY CONTENT, INCLUDING ANY RELIANCE ON THE ACCURACY, COMPLETENESS, OR USEFULNESS OF SUCH CONTENT. YOU SPECIFICALLY ACKNOWLEDGE THAT WALK INTO THE WILD IS NOT LIABLE FOR THE DEFAMATORY, OFFENSIVE, OR ILLEGAL CONDUCT OF USERS OR THIRD PARTIES.</p>
          <p>ADDITIONALLY, IN NO EVENT WILL WALK INTO THE WILD OR ITS AFFILIATES BE LIABLE FOR ANY SPECIAL, INDIRECT, INCIDENTAL, PUNITIVE, OR CONSEQUENTIAL DAMAGES, INCLUDING, WITHOUT LIMITATION, ANY LOSS OF USE, LOSS OF PROFITS, LOSS OF DATA, COST OF PROCUREMENT OF SUBSTITUTE PRODUCTS OR SERVICES, OR ANY OTHER SUCH DAMAGES, HOWSOEVER CAUSED, AND ON ANY THEORY OF LIABILITY, WHETHER FOR BREACH OF CONTRACT, TORT (INCLUDING NEGLIGENCE AND STRICT LIABILITY), OR OTHERWISE RESULTING FROM (1) THE USE OF, OR THE INABILITY TO USE THE WEBSITE; (2) THE COST OF PROCUREMENT OF SUBSTITUTE SERVICES, ITEMS, OR WEBSITES; (3) UNAUTHORIZED ACCESS TO OR ALTERATION OF YOUR TRANSMISSIONS OR DATA; (4) THE STATEMENTS OR CONDUCT OF ANY THIRD PARTY ON THE WEBSITE; OR (5) ANY OTHER MATTER RELATING TO THE WEBSITE. THESE LIMITATIONS WILL APPLY WHETHER OR NOT WALK INTO THE WILD HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES AND NOTWITHSTANDING ANY FAILURE OF THE ESSENTIAL PURPOSE OF ANY LIMITED REMEDY.</p>
          </p>
          <h6>Indemnification</h6>
          <p>You agree to indemnify and hold harmless Walk Into The Wild, its directors, officers, employees, owners, agents, and affiliates, from and against any and all liability, damages, losses, claims, and expenses of any kind (including, without limitation, reasonable attorneys' fees) directly or indirectly related to (1) your breach of the Agreement; or (2) the user content you submit, post, or transmit through the website.</p>
          
          <h6>Your account</h6>
          <p>You are accountable for safeguarding the confidentiality of any passwords linked to your account on our website, monitoring all activity under the account, and taking full responsibility for all actions occurring under your account.</p>
          
          <h6>Modification or suspension of our website</h6>
          <p>We may at any time modify, discontinue, or suspend the operation of our website, or any part thereof, temporarily or permanently, without notice to you. </p>
          
          <h6>Change of ownership</h6>
          <p>If we are in the process of selling Walk Into The Wild, our website, or substantial parts of our business, you agree we may disclose and/or transfer your personally identifiable information as well as other information to the (potential) new owner so they can better value our business and, if sold, continue to operate the service this website provides. This will also be the case if the new owner is a non-EU company, organization, or individual.</p>
          <p>You also agree that in the event of a change in ownership of Walk Into The Wild or our website, the rights, obligations, and restrictions you have towards us, as outlined in this agreement, will be transferred to the new owner without notice to you, and you accept the new owner as your new counterparty in this Agreement.</p>
          <h6>Termination of this Agreement</h6>
          <p>Either party may terminate the Agreement for any reason or without cause, at any time, by notice, which shall be effective immediately or as specified in the notice. After termination, you shall no longer access Walk Into The Wild's website. The provisions of this Agreement which, by their intent or meaning, are intended to survive such termination shall continue to apply indefinitely.</p>
          <h6>Severability of Agreement</h6>
          <p>If any provision of the Agreement is deemed invalid by a court or other binding authority, you agree that every effort shall be made to uphold the parties' intentions as reflected in that provision. The remaining provisions of the Agreement, which are not affected by such invalidity, shall remain in full force and effect.</p>
          <h6>Complaints regarding content</h6>
          <p>For making complaints regarding copyright infringement of our content or regarding our content in general, please send an email to <a href="mailto:contact@walkintothewild.in">contact@walkintothewild.in</a></p>

          
        </div>


      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="modalsafritermsForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">TERMS & CONDITIONS</h1>
        <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body modal_form">
        <div class="terms_details">
          <h6 class=" pb-3">By accessing, using, or signing up for this website, newsletters, or any services, you enter into a legally binding agreement with Walk Into The Wild based on these terms.</h6>

          <h6>Introduction</h6>
          <p>Welcome to the <a href="https://www.walkintothewild.in/" target="_blank">www.walkintothewild.in</a> website ("Website", "website", "Site" or "site"). This website, its pages, the content, services, and infrastructure are owned, operated, and provided by Walk Into The Wild ("Walk Into The Wild", "Us", "us", "We" or "we") or other parties. The website and its content are provided for your personal, non-commercial use only, subject to the terms of use as set out below. These terms of use (this "Agreement") set forth the terms and conditions governing your use of this website.</p>
          <h6>Modifications to this Agreement</h6>
          <p>We reserve the right to modify this Agreement at our sole discretion. Changes are effective immediately upon updating this page. Please review this Agreement periodically. By continuing to use our website after changes are made, you accept those changes.</p>
          <h6>Privacy</h6>
          <p>We outline our current practices regarding personally identifiable and other information collected through our website in our Privacy Policy. We reserve the right to update our policies and practices at our sole discretion. By using our website, you acknowledge that you have read and agree to our privacy policy.</p>
          <h6>Your use of content and information (disclaimer)</h6>
          <p>We offer a diverse range of content on our website, including information, advice, recommendations, messages, comments, posts, text, graphics, software, music, sound, photographs, videos, data, and other materials ("Content" or "content"). Some content is provided by us or our suppliers, while other content is contributed by users of our website ("Users" or "users"), such as opinions and views shared via reviews, chat rooms, blogs, or message boards. While we strive to ensure the accuracy, completeness, and timeliness of the content on our website, we cannot guarantee it and are not responsible for any inaccuracies, omissions, or delays, whether in content provided by us, our suppliers, or users. Any opinions, advice, statements, or other information expressed by users or third parties are solely their own and do not represent our views.</p>
          <p>We are not obligated to prescreen, edit, or remove any user-provided content posted on or available through our website. However, we reserve the right (but not the obligation), at our sole discretion and for any reason, to prescreen, edit, refuse, remove, or relocate any such content.</p>
          <h6>User generated content</h6>
          <p>User-generated content ("User Content" or "user content") refers to information provided by our users with the intention of being published on our website (e.g., writing a review or posting on our boards). As a user of our website, you assume responsibility for all user content that you submit, post, or otherwise make available through our platform.</p>
          <p>While we do not claim ownership of user content, by submitting, posting, or otherwise making content available through our website, you automatically grant us the right to utilize your user content as we see fit. This includes the non-exclusive, perpetual, transferable, irrevocable right, with the right of sublicensing, and without any royalty or compensation in return, to use, reproduce, modify, translate, distribute, publish, create derivative works, disclose, and duplicate the content across all known and future media. You acknowledge that we may determine how your user content is credited and accept that the content provided may be indexed by search engines such as Google. Additionally, you grant us and any third party appointed by us the right to take legal actions deemed necessary for the protection of the rights of your user content, including, but not limited to, taking legal action on your behalf.</p>
          <p>You agree not to submit, post, or otherwise make available through our website any personally identifiable information about other people or any abusive, obscene, vulgar, slanderous, hateful, threatening, sexually-oriented user content, or any other material that may violate any laws, whether of your country, the Indian, any other country, or international law. You confirm that such user content is not confidential and that you have all necessary permissions to submit, post, and otherwise make available such user content. Moreover, you undertake not to submit, post, or otherwise make available through our website any commercial, advertising, promotional, or spam-like user content. Violation of any of these conditions may lead to immediate and permanent banning, with notification to your Internet Service Provider if deemed necessary by us, and we reserve the right to take other legal action. You agree that we have the discretion to remove, edit, move, or close your account and/or any user content at any time as we deem appropriate.</p>
         
          <h6>Ownership and Intellectual property rights</h6>
          <p>This website is owned by Walk Into The Wild. All rights and interest in the content available via the website, the website's look and feel, the designs, trademarks, service marks, and trade names displayed on the website, and the website URL are the property of Walk Into The Wild or its licensors, and are protected by copyrights, trademarks, patents, or other proprietary rights and laws. You may not use any content available via the website in any manner or for any purpose without the prior written permission of us or, if applicable, our licensors. All rights not expressly granted in this Agreement are expressly reserved to Walk Into The Wild and its licensors.</p>
          <h6>Your contact with advertisers or other third parties</h6>
          <p>Your interactions with advertisers or other third parties found on or accessible through our website are exclusively between you and the third party. These interactions encompass, but are not limited to, your engagement in promotions, the payment for and receipt of items such as safari tours, if any, and any terms, conditions, warranties, or representations associated with such transactions. Your access and use of such sites, including the content, items, or services offered on those sites, is solely at your own risk. We do not provide any assurances or guarantees regarding the content or privacy practices of such third parties, or otherwise concerning the services or items provided by them. By using our website, you acknowledge and agree that we bear no responsibility for any loss or damage of any nature arising from your dealings with any third party or their presence on our website.</p>
          <h6>Disclaimer of warranties</h6>
          <p>THE WEBSITE IS PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS. WALK INTO THE WILD EXPRESSLY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, WITHOUT LIMITATION, ANY WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NONINFRINGEMENT. WALK INTO THE WILD DOES NOT MAKE ANY WARRANTY THAT THE WEBSITE WILL MEET YOUR REQUIREMENTS, OR THAT ACCESS TO THE WEBSITE WILL BE UNINTERRUPTED, TIMELY, SECURE, OR ERROR-FREE, OR THAT DEFECTS, IF ANY, WILL BE CORRECTED. WALK INTO THE WILD MAKES NO WARRANTIES AS TO THE RESULTS THAT MAY BE OBTAINED FROM THE USE OF THE WEBSITE OR AS TO THE ACCURACY, QUALITY, OR RELIABILITY OF ANY INFORMATION OBTAINED THROUGH THE WEBSITE.</p>
          <h6>Disclaimer of warranties</h6>
          <p>WALK INTO THE WILD AND ITS AFFILIATES ASSUME NO RESPONSIBILITY FOR ANY CONSEQUENCES DIRECTLY OR INDIRECTLY RELATED TO ANY ACTION OR INACTION YOU TAKE BASED ON THE CONTENT AVAILABLE VIA THE WEBSITE. YOU MUST ASSESS AND BEAR ALL RISKS ASSOCIATED WITH THE USE OF ANY CONTENT, INCLUDING ANY RELIANCE ON THE ACCURACY, COMPLETENESS, OR USEFULNESS OF SUCH CONTENT. YOU SPECIFICALLY ACKNOWLEDGE THAT WALK INTO THE WILD IS NOT LIABLE FOR THE DEFAMATORY, OFFENSIVE, OR ILLEGAL CONDUCT OF USERS OR THIRD PARTIES.</p>
          <p>ADDITIONALLY, IN NO EVENT WILL WALK INTO THE WILD OR ITS AFFILIATES BE LIABLE FOR ANY SPECIAL, INDIRECT, INCIDENTAL, PUNITIVE, OR CONSEQUENTIAL DAMAGES, INCLUDING, WITHOUT LIMITATION, ANY LOSS OF USE, LOSS OF PROFITS, LOSS OF DATA, COST OF PROCUREMENT OF SUBSTITUTE PRODUCTS OR SERVICES, OR ANY OTHER SUCH DAMAGES, HOWSOEVER CAUSED, AND ON ANY THEORY OF LIABILITY, WHETHER FOR BREACH OF CONTRACT, TORT (INCLUDING NEGLIGENCE AND STRICT LIABILITY), OR OTHERWISE RESULTING FROM (1) THE USE OF, OR THE INABILITY TO USE THE WEBSITE; (2) THE COST OF PROCUREMENT OF SUBSTITUTE SERVICES, ITEMS, OR WEBSITES; (3) UNAUTHORIZED ACCESS TO OR ALTERATION OF YOUR TRANSMISSIONS OR DATA; (4) THE STATEMENTS OR CONDUCT OF ANY THIRD PARTY ON THE WEBSITE; OR (5) ANY OTHER MATTER RELATING TO THE WEBSITE. THESE LIMITATIONS WILL APPLY WHETHER OR NOT WALK INTO THE WILD HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES AND NOTWITHSTANDING ANY FAILURE OF THE ESSENTIAL PURPOSE OF ANY LIMITED REMEDY.</p>
          </p>
          <h6>Indemnification</h6>
          <p>You agree to indemnify and hold harmless Walk Into The Wild, its directors, officers, employees, owners, agents, and affiliates, from and against any and all liability, damages, losses, claims, and expenses of any kind (including, without limitation, reasonable attorneys' fees) directly or indirectly related to (1) your breach of the Agreement; or (2) the user content you submit, post, or transmit through the website.</p>
          
          <h6>Your account</h6>
          <p>You are accountable for safeguarding the confidentiality of any passwords linked to your account on our website, monitoring all activity under the account, and taking full responsibility for all actions occurring under your account.</p>
          
          <h6>Modification or suspension of our website</h6>
          <p>We may at any time modify, discontinue, or suspend the operation of our website, or any part thereof, temporarily or permanently, without notice to you. </p>
          
          <h6>Change of ownership</h6>
          <p>If we are in the process of selling Walk Into The Wild, our website, or substantial parts of our business, you agree we may disclose and/or transfer your personally identifiable information as well as other information to the (potential) new owner so they can better value our business and, if sold, continue to operate the service this website provides. This will also be the case if the new owner is a non-EU company, organization, or individual.</p>
          <p>You also agree that in the event of a change in ownership of Walk Into The Wild or our website, the rights, obligations, and restrictions you have towards us, as outlined in this agreement, will be transferred to the new owner without notice to you, and you accept the new owner as your new counterparty in this Agreement.</p>
          <h6>Termination of this Agreement</h6>
          <p>Either party may terminate the Agreement for any reason or without cause, at any time, by notice, which shall be effective immediately or as specified in the notice. After termination, you shall no longer access Walk Into The Wild's website. The provisions of this Agreement which, by their intent or meaning, are intended to survive such termination shall continue to apply indefinitely.</p>
          <h6>Severability of Agreement</h6>
          <p>If any provision of the Agreement is deemed invalid by a court or other binding authority, you agree that every effort shall be made to uphold the parties' intentions as reflected in that provision. The remaining provisions of the Agreement, which are not affected by such invalidity, shall remain in full force and effect.</p>
          <h6>Complaints regarding content</h6>
          <p>For making complaints regarding copyright infringement of our content or regarding our content in general, please send an email to <a href="mailto:contact@walkintothewild.in">contact@walkintothewild.in</a></p>

          
        </div>
      </div>

    </div>
  </div>
</div>