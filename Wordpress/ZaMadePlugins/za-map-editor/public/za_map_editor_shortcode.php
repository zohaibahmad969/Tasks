<?php

add_shortcode( 'za-map-editor' , 'za_map_editor_shortcode_fn');
function za_map_editor_shortcode_fn() {
	$output = '
	<link rel="stylesheet" href="'.plugin_dir_url( __FILE__ ) .'css/panel-style.css" media="all">
	<link rel="stylesheet" href="'.plugin_dir_url( __FILE__ ) .'css/style.css">
  <link rel="stylesheet" href="'.plugin_dir_url( __FILE__ ) .'css/za-style.css">
  
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJfzOqR9u2eyXv6OaiuExD3jzoBGGIVKY&libraries=geometry,places&v=weekly"></script>

<app-root _nghost-bbw-c60="" ng-version="12.2.16">

    <router-outlet _ngcontent-bbw-c60=""></router-outlet>
    <app-maps-editor _nghost-bbw-c195="">
      <app-poster-layout _ngcontent-bbw-c195="" _nghost-bbw-c75="">
        <div _ngcontent-bbw-c75="" class="layout">
          <app-container _ngcontent-bbw-c75="" _nghost-bbw-c14="">
            <div _ngcontent-bbw-c14="" class="pp-content no-mobile-padding">
              <div _ngcontent-bbw-c75="" class="left-section">
                <div _ngcontent-bbw-c195="" tabs="">
                  <app-tabs _ngcontent-bbw-c195="" _nghost-bbw-c80="">
                    <div _ngcontent-bbw-c80="" class="tabs-3 tabs-container">
                      <div _ngcontent-bbw-c80="" class="tab app-design-tab active" data-tab="app-maps-design">
                        <div _ngcontent-bbw-c80="" class="icon">
                          <svg-icon _ngcontent-bbw-c80=""><svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                              xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c80="" aria-hidden="true"
                              style="width: 20px;">
                              <path
                                d="M10.5 0C15.8011 0 20.1 3.978 20.1 8.889C20.0993 10.3622 19.537 11.7748 18.5369 12.8165C17.5368 13.8581 16.1805 14.4435 14.7663 14.444H12.8789C11.9938 14.444 11.2786 15.189 11.2786 16.111C11.2786 16.533 11.4389 16.922 11.6837 17.211C11.94 17.511 12.1003 17.9 12.1003 18.333C12.1003 19.256 11.364 20 10.5 20C5.1989 20 0.900024 15.522 0.900024 10C0.900024 4.478 5.1989 0 10.5 0ZM9.35858 16.111C9.35821 15.6293 9.449 15.1523 9.62578 14.7072C9.80256 14.2622 10.0619 13.8578 10.3888 13.5172C10.7158 13.1766 11.104 12.9065 11.5313 12.7223C11.9586 12.5382 12.4165 12.4436 12.8789 12.444H14.7663C15.6712 12.4435 16.5389 12.0689 17.1789 11.4026C17.819 10.7363 18.179 9.8326 18.18 8.89C18.18 5.139 14.7893 2 10.5 2C8.51818 1.99812 6.61235 2.79436 5.18103 4.22225C3.7497 5.65014 2.90369 7.59913 2.81989 9.66171C2.73608 11.7243 3.42097 13.7408 4.73135 15.2895C6.04173 16.8383 7.87615 17.7994 9.85106 17.972C9.52962 17.4093 9.35951 16.7668 9.35858 16.112V16.111ZM6.18002 10C5.79811 10 5.43184 9.84196 5.16179 9.56066C4.89174 9.27936 4.74002 8.89782 4.74002 8.5C4.74002 8.10218 4.89174 7.72064 5.16179 7.43934C5.43184 7.15804 5.79811 7 6.18002 7C6.56194 7 6.92821 7.15804 7.19826 7.43934C7.46831 7.72064 7.62002 8.10218 7.62002 8.5C7.62002 8.89782 7.46831 9.27936 7.19826 9.56066C6.92821 9.84196 6.56194 10 6.18002 10ZM14.82 10C14.4381 10 14.0718 9.84196 13.8018 9.56066C13.5317 9.27936 13.38 8.89782 13.38 8.5C13.38 8.10218 13.5317 7.72064 13.8018 7.43934C14.0718 7.15804 14.4381 7 14.82 7C15.2019 7 15.5682 7.15804 15.8383 7.43934C16.1083 7.72064 16.26 8.10218 16.26 8.5C16.26 8.89782 16.1083 9.27936 15.8383 9.56066C15.5682 9.84196 15.2019 10 14.82 10ZM10.5 7C10.1181 7 9.75184 6.84196 9.48179 6.56066C9.21174 6.27936 9.06003 5.89782 9.06002 5.5C9.06002 5.10218 9.21174 4.72064 9.48179 4.43934C9.75184 4.15804 10.1181 4 10.5 4C10.8819 4 11.2482 4.15804 11.5183 4.43934C11.7883 4.72064 11.94 5.10218 11.94 5.5C11.94 5.89782 11.7883 6.27936 11.5183 6.56066C11.2482 6.84196 10.8819 7 10.5 7Z"
                                _ngcontent-bbw-c80=""></path>
                            </svg></svg-icon>
                        </div><span _ngcontent-bbw-c80="" class="tab-title">Design</span>
                      </div>

                      <div _ngcontent-bbw-c80="" class="tab app-details-tab"  data-tab="app-maps-details">
                        <div _ngcontent-bbw-c80="" class="icon">
                          <svg-icon _ngcontent-bbw-c80=""><svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                              xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c80="" aria-hidden="true"
                              style="width: 20px;">
                              <path
                                d="M9.9999 20C4.69782 20 0.399902 15.523 0.399902 10C0.399902 4.477 4.69782 0 9.9999 0C15.302 0 19.5999 4.477 19.5999 10C19.5999 15.523 15.302 20 9.9999 20ZM9.9999 18C12.0368 18 13.9902 17.1571 15.4305 15.6569C16.8708 14.1566 17.6799 12.1217 17.6799 10C17.6799 7.87827 16.8708 5.84344 15.4305 4.34315C13.9902 2.84285 12.0368 2 9.9999 2C7.96304 2 6.0096 2.84285 4.56932 4.34315C3.12904 5.84344 2.3199 7.87827 2.3199 10C2.3199 12.1217 3.12904 14.1566 4.56932 15.6569C6.0096 17.1571 7.96304 18 9.9999 18ZM9.0399 5H10.9599V7H9.0399V5ZM9.0399 9H10.9599V15H9.0399V9Z"
                                _ngcontent-bbw-c80=""></path>
                            </svg></svg-icon>
                        </div><span _ngcontent-bbw-c80="" class="tab-title">Details</span>
                      </div>

                      <div _ngcontent-bbw-c80="" class="tab app-format-tab"  data-tab="app-maps-format">
                        <div _ngcontent-bbw-c80="" class="icon">
                          <svg-icon _ngcontent-bbw-c80=""><svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                              xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c80="" aria-hidden="true"
                              style="width: 20px;">
                              <path
                                d="M6.15991 6V14H13.8399V6H6.15991ZM4.2399 4H15.7599V16H4.2399V4ZM4.2399 0H6.15991V3H4.2399V0ZM4.2399 17H6.15991V20H4.2399V17ZM0.399902 4H3.2799V6H0.399902V4ZM0.399902 14H3.2799V16H0.399902V14ZM16.7199 4H19.5999V6H16.7199V4ZM16.7199 14H19.5999V16H16.7199V14ZM13.8399 0H15.7599V3H13.8399V0ZM13.8399 17H15.7599V20H13.8399V17Z"
                                _ngcontent-bbw-c80=""></path>
                            </svg></svg-icon>
                        </div><span _ngcontent-bbw-c80="" class="tab-title">Format</span>
                      </div>


                    </div>


                  </app-tabs>
                </div>

                <div _ngcontent-bbw-c195="" editor="">
                  <app-maps-design _ngcontent-bbw-c195="" _nghost-bbw-c187="">
                    <app-tab-content-wrapper _ngcontent-bbw-c187="" _nghost-bbw-c185="">
                      <div _ngcontent-bbw-c185="" class="content-wrapper">
                        <app-details-row _ngcontent-bbw-c187="" _nghost-bbw-c81="">
                          <div _ngcontent-bbw-c81="" class="details-row">
                            <div _ngcontent-bbw-c81="" class="label">


                            </div>
                            <div _ngcontent-bbw-c81="" class="form-element">
                              <app-text-header _ngcontent-bbw-c187="" label="design.selectStyle" _nghost-bbw-c84="">
                                <div _ngcontent-bbw-c84="" class="section-title">
                                  <span _ngcontent-bbw-c84="">Style</span>
                                </div>
                              </app-text-header>
                            </div>
                          </div>
                        </app-details-row>
                        <app-style-grid _ngcontent-bbw-c187="" _nghost-bbw-c85="">
                          <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-grid app-grid-style">
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector active" data-mapStyle="square">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      src="'.plugin_dir_url( __FILE__ ) .'images/square.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Square</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector" data-mapStyle="circle">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      src="'.plugin_dir_url( __FILE__ ) .'images/circle.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Circle</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector" style="display: none;">
                                <div _ngcontent-bbw-c88="" class="selector" data-mapStyle="heart">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      src="'.plugin_dir_url( __FILE__ ) .'images/heart.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Heart</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector" style="display: none;">
                                <div _ngcontent-bbw-c88="" class="selector" data-mapStyle="house">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      src="'.plugin_dir_url( __FILE__ ) .'images/house.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">House</div>

                                </div>

                              </div>
                            </app-style-selector>

                          </div>
                        </app-style-grid>
                        <app-details-row _ngcontent-bbw-c187="" _nghost-bbw-c81="">
                          <div _ngcontent-bbw-c81="" class="details-row">
                            <div _ngcontent-bbw-c81="" class="label">


                            </div>
                            <div _ngcontent-bbw-c81="" class="form-element one-liner">
                              <app-text-header _ngcontent-bbw-c187="" label="design.colorScheme" _nghost-bbw-c84="">
                                <div _ngcontent-bbw-c84="" class="section-title">
                                  <span _ngcontent-bbw-c84="">Color scheme</span>
                                </div>
                              </app-text-header>
                              <app-info-icon _ngcontent-bbw-c187="" _nghost-bbw-c82="">
                                <div _ngcontent-bbw-c82="" class="icon">
                                  <svg-icon _ngcontent-bbw-c82=""><svg width="24" height="24" viewBox="0 0 24 24"
                                      fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c82=""
                                      aria-hidden="true">
                                      <circle cx="12" cy="12" r="10.25" stroke="#16212C" stroke-width="1.5"
                                        _ngcontent-bbw-c82=""></circle>
                                      <rect x="11.25" y="10" width="1.5" height="8" fill="#16212C"
                                        _ngcontent-bbw-c82=""></rect>
                                      <rect x="11.25" y="7" width="1.5" height="1.5" fill="#16212C"
                                        _ngcontent-bbw-c82=""></rect>
                                    </svg></svg-icon>
                                </div>
                              </app-info-icon>
                            </div>
                          </div>
                        </app-details-row>
                        <app-style-grid _ngcontent-bbw-c187="" _nghost-bbw-c85="">
                          <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-grid app-color-scheme">
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector" data-color="minimal_styles">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      class="color-scheme" src="'.plugin_dir_url( __FILE__ ) .'images/minimal.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Minimal</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector" data-color="beachglass_styles">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      class="color-scheme" src="'.plugin_dir_url( __FILE__ ) .'images/beachglass.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Beachglass</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector" data-color="carbon_styles">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      class="color-scheme" src="'.plugin_dir_url( __FILE__ ) .'images/carbon.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Carbon</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector" data-color="black_styles">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      class="color-scheme" src="'.plugin_dir_url( __FILE__ ) .'images/black.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Black</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector" data-color="vintage_styles">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      class="color-scheme" src="'.plugin_dir_url( __FILE__ ) .'images/vintage.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Vintage</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector active" data-color="atlas_styles">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      class="color-scheme" src="'.plugin_dir_url( __FILE__ ) .'images/antiqua.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Atlas</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector" data-color="classic_styles">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      class="color-scheme" src="'.plugin_dir_url( __FILE__ ) .'images/classic.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Classic</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector" data-color="pink_styles">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      class="color-scheme" src="'.plugin_dir_url( __FILE__ ) .'images/wanderlust.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Pink</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector" data-color="green_styles">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      class="color-scheme" src="'.plugin_dir_url( __FILE__ ) .'images/cosy.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Green</div>

                                </div>

                              </div>
                            </app-style-selector>
                            <app-style-selector _ngcontent-bbw-c187="" _nghost-bbw-c88="">
                              <div _ngcontent-bbw-c88="" class="style-selector">
                                <div _ngcontent-bbw-c88="" class="selector" data-color="intense_styles">
                                  <div _ngcontent-bbw-c88="" class="content"><img _ngcontent-bbw-c187=""
                                      class="color-scheme" src="'.plugin_dir_url( __FILE__ ) .'images/intense.webp"></div>
                                </div>
                                <div _ngcontent-bbw-c88="" class="label-area">
                                  <div _ngcontent-bbw-c88="" class="label">Intense</div>

                                </div>

                              </div>
                            </app-style-selector>

                          </div>
                        </app-style-grid>


                        <app-delimiter _ngcontent-bbw-c187="" _nghost-bbw-c139="">
                          <div _ngcontent-bbw-c139="" class="delimiter"></div>
                        </app-delimiter>
                      </div>
                    </app-tab-content-wrapper>
                  </app-maps-design>
                  <app-maps-details _ngcontent-bbw-c195="" _nghost-bbw-c190="" hidden="">
                    <app-tab-content-wrapper _ngcontent-bbw-c190="" _nghost-bbw-c185="">
                      <div _ngcontent-bbw-c185="" class="content-wrapper">
                        <app-details-row _ngcontent-bbw-c190="" header="details.place" _nghost-bbw-c81="">
                          <div _ngcontent-bbw-c81="" class="details-row">
                            <div _ngcontent-bbw-c81="" class="label">PLACE<span _ngcontent-bbw-c81="">*</span>


                            </div>
                            <div _ngcontent-bbw-c81="" class="form-element">
                              <app-google-autocomplete _ngcontent-bbw-c190="" _nghost-bbw-c146="">
                                <div _ngcontent-bbw-c146="" class="input-area">

                                  <input id="pac-input"   _ngcontent-bbw-c146="" type="text"
                                    class="mat-autocomplete-trigger input za-search-input controls"
                                    placeholder="For e.g.: city, street address or building" autocomplete="off"
                                    role="combobox" aria-autocomplete="list" aria-expanded="false" aria-haspopup="true">


                                </div>
                                <mat-autocomplete _ngcontent-bbw-c146="" class="mat-autocomplete">

                                </mat-autocomplete>

                              </app-google-autocomplete>
                            </div>
                          </div>
                        </app-details-row>
                        <app-details-row _ngcontent-bbw-c190="" _nghost-bbw-c81="">
                          <div _ngcontent-bbw-c81="" class="details-row" style="display: none;">
                            <div _ngcontent-bbw-c81="" class="label">


                            </div>
                            <div _ngcontent-bbw-c81="" class="form-element">
                              <app-checkbox _ngcontent-bbw-c190="" label="details.marker" _nghost-bbw-c83="">
                                <div _ngcontent-bbw-c83="" class="checkbox-element">
                                  <div _ngcontent-bbw-c83="" class="checkbox-div"><label _ngcontent-bbw-c83=""
                                      class="checkbox"><input _ngcontent-bbw-c83="" type="checkbox"
                                        class="ng-untouched ng-pristine ng-valid">


                                      <span _ngcontent-bbw-c83="" class="checkbox"></span>
                                    </label></div>
                                  <div _ngcontent-bbw-c83=""
                                    class="checkbox-info-true checkbox-label label mainText standard-weight"> Add map
                                    marker </div>

                                  <div _ngcontent-bbw-c83="" class="info">
                                    <app-info-icon _ngcontent-bbw-c83="" _nghost-bbw-c82="">
                                      <div _ngcontent-bbw-c82="" class="icon">
                                        <svg-icon _ngcontent-bbw-c82=""><svg width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c82=""
                                            aria-hidden="true">
                                            <circle cx="12" cy="12" r="10.25" stroke="#16212C" stroke-width="1.5"
                                              _ngcontent-bbw-c82=""></circle>
                                            <rect x="11.25" y="10" width="1.5" height="8" fill="#16212C"
                                              _ngcontent-bbw-c82=""></rect>
                                            <rect x="11.25" y="7" width="1.5" height="1.5" fill="#16212C"
                                              _ngcontent-bbw-c82=""></rect>
                                          </svg></svg-icon>
                                      </div>
                                    </app-info-icon>
                                  </div>

                                </div>
                              </app-checkbox>
                            </div>
                          </div>
                        </app-details-row>
                        <app-delimiter _ngcontent-bbw-c190="" _nghost-bbw-c139="">
                          <div _ngcontent-bbw-c139="" class="delimiter"></div>
                        </app-delimiter>


                        <app-delimiter _ngcontent-bbw-c190="" _nghost-bbw-c139="">
                          <div _ngcontent-bbw-c139="" class="delimiter border-top"></div>
                        </app-delimiter>
                        <app-details-row _ngcontent-bbw-c190="" _nghost-bbw-c81="">
                          <div _ngcontent-bbw-c81="" class="details-row">
                            <div _ngcontent-bbw-c81="" class="label">


                            </div>
                            <div _ngcontent-bbw-c81="" class="form-element">

                              <app-text-header _ngcontent-bbw-c190="" label="details.texts.mapText" class="checkbox"
                                _nghost-bbw-c84="">
                                <div _ngcontent-bbw-c84="" class="section-title details with-checkbox">
                                  <app-checkbox _ngcontent-bbw-c84="" _nghost-bbw-c83="">
                                    <div _ngcontent-bbw-c83="" class="checkbox-element">
                                      <div _ngcontent-bbw-c83="" class="checkbox-div"><label _ngcontent-bbw-c83=""
                                          class="checkbox"><input id="za_map_title_checkbox" _ngcontent-bbw-c83="" type="checkbox"
                                            class="ng-untouched ng-pristine ng-valid" checked="checked">


                                          <span _ngcontent-bbw-c83="" class="checkbox"></span>
                                        </label></div>


                                    </div>
                                  </app-checkbox>
                                  <span _ngcontent-bbw-c84="">Map title</span>
                                </div>
                              </app-text-header>
                              <span _ngcontent-bbw-c190=""></span>
                              <app-explanation-line _ngcontent-bbw-c190="" _nghost-bbw-c189="">
                                <p _ngcontent-bbw-c189="" class="za-map-title-checkbox-element">The default title and coordinates can be edited</p>
                              </app-explanation-line>

                            </div>
                          </div>
                        </app-details-row>
                        <app-details-row _ngcontent-bbw-c190="" header="details.texts.large" _nghost-bbw-c81="">
                          <div _ngcontent-bbw-c81="" class="details-row za-map-title-checkbox-element" >
                            <div _ngcontent-bbw-c81="" class="label">LARGE TEXT


                            </div>
                            <div _ngcontent-bbw-c81="" class="form-element">
                              <app-details-textarea _ngcontent-bbw-c190="" placeholder="details.title.placeholder"
                                _nghost-bbw-c128=""><textarea id="map_title_larger_text" _ngcontent-bbw-c128="" autosize="" rows="1"
                                  class="input textArea ng-untouched ng-pristine ng-valid"
                                  placeholder="Write your title text here" maxlength="999"
                                  style="overflow-y: hidden; height: 30px;"></textarea>





                              </app-details-textarea>
                              <app-checkbox _ngcontent-bbw-c190="" _nghost-bbw-c83="">
                                <div _ngcontent-bbw-c83="" class="checkbox-element">
                                  <div _ngcontent-bbw-c83="" class="checkbox-div"><label _ngcontent-bbw-c83=""
                                      class="checkbox"><input id="za_script_font_checkbox" _ngcontent-bbw-c83="" type="checkbox"
                                        class="ng-untouched ng-pristine ng-valid">


                                      <span _ngcontent-bbw-c83="" class="checkbox"></span>
                                    </label></div>
                                  <div _ngcontent-bbw-c83=""
                                    class="checkbox-info- checkbox-label label mainText standard-weight"> Script font
                                  </div>


                                </div>
                              </app-checkbox>
                            </div>
                          </div>
                        </app-details-row>
                        <app-details-row _ngcontent-bbw-c190="" header="details.subtitle.header" _nghost-bbw-c81="">
                          <div _ngcontent-bbw-c81="" class="details-row big-top-margin za-map-title-checkbox-element">
                            <div _ngcontent-bbw-c81="" class="label">SMALL TEXT


                            </div>
                            <div _ngcontent-bbw-c81="" class="form-element">
                              <app-details-textarea _ngcontent-bbw-c190="" _nghost-bbw-c128=""><textarea id="map_title_smaller_text"
                                  _ngcontent-bbw-c128="" autosize="" rows="1"
                                  class="input textArea ng-untouched ng-pristine ng-valid"
                                  placeholder="Write your title text here" maxlength="999"
                                  style="overflow-y: hidden; height: 30px;"></textarea>





                              </app-details-textarea>
                            </div>
                          </div>
                        </app-details-row>



                      </div>
                    </app-tab-content-wrapper>


                    <app-tab-content-wrapper _ngcontent-bbw-c190="" _nghost-bbw-c185="">
                      <div _ngcontent-bbw-c185="" class="content-wrapper">

                      </div>
                    </app-tab-content-wrapper>

                  </app-maps-details>
                  <app-maps-format _ngcontent-bbw-c195="" _nghost-bbw-c191="" hidden="">
                    <app-tab-content-wrapper _ngcontent-bbw-c191="" _nghost-bbw-c185="">
                      <div _ngcontent-bbw-c185="" class="content-wrapper">
                        <app-new-format _ngcontent-bbw-c191="" _nghost-bbw-c90="">
                          <app-details-row _ngcontent-bbw-c90="" _nghost-bbw-c81="">
                            <div _ngcontent-bbw-c81="" class="details-row">
                              <div _ngcontent-bbw-c81="" class="label">


                              </div>
                              <div _ngcontent-bbw-c81="" class="form-element">
                                <app-text-header _ngcontent-bbw-c90="" label="format.selectStyle" _nghost-bbw-c84="">
                                  <div _ngcontent-bbw-c84="" class="section-title">
                                    <span _ngcontent-bbw-c84="">Product type</span>
                                  </div>
                                </app-text-header>
                              </div>
                            </div>
                          </app-details-row>
                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-4 style-mobile-grid-4 style-grid app-grid-product-type">
                              <app-style-selector _ngcontent-bbw-c90="" _nghost-bbw-c88="">
                                <div _ngcontent-bbw-c88="" class="style-selector">
                                  <div _ngcontent-bbw-c88="" class="selector active" data-productType="printed">
                                    <div _ngcontent-bbw-c88="" class="content">
                                      <svg-icon _ngcontent-bbw-c90=""><svg width="48" height="48" viewBox="0 0 48 48"
                                          fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c90=""
                                          aria-hidden="true">
                                          <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M14 2H15.5V7H16.25H17.75V8.5V9.25H29.75V8.5V7H31.25H32V2H33.5V7H34.25H35.75V8.5V9.25H38.75H39.5V10V44V44.75H38.75H8.75H8V44V10V9.25H8.75H11.75V8.5V7H13.25H14V2ZM16.25 8.5H13.25V11.5H16.25V8.5ZM29.75 10.75H17.75V11.5V13H16.25H13.25H11.75V11.5V10.75H9.5V43.25H38V10.75H35.75V11.5V13H34.25H31.25H29.75V11.5V10.75ZM31.25 8.5H34.25V11.5H31.25V8.5ZM26.2536 21.4821L26.9029 22.631L33.4029 34.131C33.6067 34.4916 33.4796 34.9491 33.119 35.1529C32.7584 35.3567 32.3009 35.2296 32.0971 34.869L26.2464 24.5179L22.9012 30.3721L22.2788 31.4612L21.614 30.3975L19.7694 27.4462L15.3965 34.8803C15.1864 35.2373 14.7268 35.3565 14.3697 35.1465C14.0127 34.9364 13.8935 34.4768 14.1035 34.1197L19.1035 25.6197L19.7306 24.5538L20.386 25.6025L22.2212 28.5388L25.5988 22.6279L26.2536 21.4821ZM31.25 22C32.0784 22 32.75 21.3284 32.75 20.5C32.75 19.6716 32.0784 19 31.25 19C30.4216 19 29.75 19.6716 29.75 20.5C29.75 21.3284 30.4216 22 31.25 22Z"
                                            fill="#16212C" _ngcontent-bbw-c90=""></path>
                                        </svg></svg-icon>
                                    </div>
                                  </div>
                                  <div _ngcontent-bbw-c88="" class="label-area">
                                    <div _ngcontent-bbw-c88="" class="label">Printed poster</div>

                                  </div>

                                </div>
                              </app-style-selector>
                              <app-style-selector _ngcontent-bbw-c90="" _nghost-bbw-c88="">
                                <div _ngcontent-bbw-c88="" class="style-selector">
                                  <div _ngcontent-bbw-c88="" class="selector" data-productType="framed">
                                    <div _ngcontent-bbw-c88="" class="content">
                                      <svg-icon _ngcontent-bbw-c90=""><svg width="48" height="48" viewBox="0 0 48 48"
                                          fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c90=""
                                          aria-hidden="true">
                                          <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M35.9393 7L37.4393 5.5L10.5607 5.5L12.0607 7H12.5L35.5 7H35.9393ZM9.5 42.4393L9.5 6.56066L11 8.06066V8.5L11 40.5V40.9393L9.5 42.4393ZM10.5607 43.5H37.4393L35.9393 42H35.5H12.5H12.0607L10.5607 43.5ZM37 40.9393L38.5 42.4393L38.5 6.56066L37 8.06066V8.5L37 40.5V40.9393ZM40 4V5.5L40 43.5V45H38.5H9.5H8V43.5V5.5L8 4H9.5H38.5H40ZM35.5 8.5L35.5 40.5H12.5L12.5 8.5L35.5 8.5ZM26.2536 18.4821L26.9029 19.631L33.4029 31.131C33.6067 31.4916 33.4796 31.9491 33.119 32.1529C32.7584 32.3567 32.3009 32.2296 32.0971 31.869L26.2464 21.5179L22.9012 27.3721L22.2788 28.4612L21.614 27.3975L19.7694 24.4462L15.3965 31.8803C15.1864 32.2373 14.7268 32.3565 14.3697 32.1465C14.0127 31.9364 13.8935 31.4768 14.1035 31.1197L19.1035 22.6197L19.7306 21.5538L20.386 22.6025L22.2212 25.5388L25.5988 19.6279L26.2536 18.4821ZM31.25 20C32.0784 20 32.75 19.3284 32.75 18.5C32.75 17.6716 32.0784 17 31.25 17C30.4216 17 29.75 17.6716 29.75 18.5C29.75 19.3284 30.4216 20 31.25 20Z"
                                            fill="#16212C" _ngcontent-bbw-c90=""></path>
                                        </svg></svg-icon>
                                    </div>
                                  </div>
                                  <div _ngcontent-bbw-c88="" class="label-area">
                                    <div _ngcontent-bbw-c88="" class="label">Framed poster</div>

                                  </div>

                                </div>
                              </app-style-selector>
                              <app-style-selector _ngcontent-bbw-c90="" _nghost-bbw-c88="">
                                <div _ngcontent-bbw-c88="" class="style-selector">
                                  <div _ngcontent-bbw-c88="" class="selector"  data-productType="streched">
                                    <div _ngcontent-bbw-c88="" class="content">
                                      <svg-icon _ngcontent-bbw-c90=""><svg width="48" height="48" viewBox="0 0 48 48"
                                          fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c90=""
                                          aria-hidden="true">
                                          <path d="M4.75 34.25V8.75H44.25V34.25H4.75Z" stroke="#16212C"
                                            stroke-width="1.5" _ngcontent-bbw-c90=""></path>
                                          <circle cx="33.5" cy="15.5" r="1.5" fill="#16212C" _ngcontent-bbw-c90="">
                                          </circle>
                                          <path d="M16 27.5L21 19L23.5 23L27.5 16L34 27.5" stroke="#16212C"
                                            stroke-width="1.5" stroke-linecap="round" _ngcontent-bbw-c90=""></path>
                                          <path d="M21.75 4.75H27.25V7.75H21.75V4.75Z" stroke="#16212C"
                                            stroke-width="1.5" _ngcontent-bbw-c90=""></path>
                                          <rect x="7.75" y="34.75" width="33.5" height="2.5" stroke="#16212C"
                                            stroke-width="1.5" _ngcontent-bbw-c90=""></rect>
                                          <rect x="24.25" y="38" width="1.5" height="6" fill="#16212C"
                                            _ngcontent-bbw-c90=""></rect>
                                          <rect x="28" y="37.75" width="1.5" height="9" transform="rotate(-30 28 37.75)"
                                            fill="#16212C" _ngcontent-bbw-c90=""></rect>
                                          <rect width="1.5" height="9"
                                            transform="matrix(-0.866025 -0.5 -0.5 0.866025 21.799 37.75)" fill="#16212C"
                                            _ngcontent-bbw-c90=""></rect>
                                        </svg></svg-icon>
                                    </div>
                                  </div>
                                  <div _ngcontent-bbw-c88="" class="label-area">
                                    <div _ngcontent-bbw-c88="" class="label">Stretched canvas</div>

                                  </div>

                                </div>
                              </app-style-selector>
                              <app-style-selector _ngcontent-bbw-c90="" _nghost-bbw-c88="">
                                <div _ngcontent-bbw-c88="" class="style-selector">
                                  <div _ngcontent-bbw-c88="" class="selector"  data-productType="digital">
                                    <div _ngcontent-bbw-c88="" class="content">
                                      <svg-icon _ngcontent-bbw-c90=""><svg width="48" height="48" viewBox="0 0 48 48"
                                          fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c90=""
                                          aria-hidden="true">
                                          <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.75 5H8V5.75V43.75V44.5H8.75H38.25H39V43.75V12.25V11.9393L38.7803 11.7197L38.5304 11.4697L38.5303 11.4697L32.5303 5.46967L32.2803 5.21967L32.0607 5H31.75H8.75ZM31.25 6.5H9.5V43H37.5V12.75H32C31.5858 12.75 31.25 12.4142 31.25 12V6.5ZM36.1893 11.25L32.75 7.81066V11.25H36.1893ZM24.4393 19.75H22.9393V28.3713L20.5 25.932L19.4393 26.9926L22.6213 30.1746L23.682 31.2353L24.7426 30.1746L27.9246 26.9926L26.864 25.932L24.4393 28.3566V19.75ZM28.75 31.75H18.75V33.25H28.75V31.75Z"
                                            fill="#16212C" _ngcontent-bbw-c90=""></path>
                                        </svg></svg-icon>
                                    </div>
                                  </div>
                                  <div _ngcontent-bbw-c88="" class="label-area">
                                    <div _ngcontent-bbw-c88="" class="label">Digital file</div>

                                  </div>

                                </div>
                              </app-style-selector>

                            </div>
                          </app-style-grid>
                          <app-info-box _ngcontent-bbw-c90="" _nghost-bbw-c86="">
                            <div _ngcontent-bbw-c86="" class="info-box">
                              <app-info-box-line _ngcontent-bbw-c90="" _nghost-bbw-c87="">
                                <div _ngcontent-bbw-c87="" class="info-line">
                                  <div _ngcontent-bbw-c87="" class="cursor">
                                    <svg-icon _ngcontent-bbw-c87=""><svg width="11" height="8" viewBox="0 0 11 8"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c87=""
                                        aria-hidden="true">
                                        <path
                                          d="M3.83343 6.34989L9.19543 0.987305L10.0208 1.81214L3.83343 7.99956L0.121094 4.28722L0.945927 3.46239L3.83343 6.34989Z"
                                          fill="black" _ngcontent-bbw-c87=""></path>
                                      </svg></svg-icon>
                                  </div>

                                  <div _ngcontent-bbw-c87="" class="text">Available immediately after purchase</div>
                                </div>
                              </app-info-box-line>
                              <app-info-box-line _ngcontent-bbw-c90="" _nghost-bbw-c87="">
                                <div _ngcontent-bbw-c87="" class="info-line">
                                  <div _ngcontent-bbw-c87="" class="cursor">
                                    <svg-icon _ngcontent-bbw-c87=""><svg width="11" height="8" viewBox="0 0 11 8"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c87=""
                                        aria-hidden="true">
                                        <path
                                          d="M3.83343 6.34989L9.19543 0.987305L10.0208 1.81214L3.83343 7.99956L0.121094 4.28722L0.945927 3.46239L3.83343 6.34989Z"
                                          fill="black" _ngcontent-bbw-c87=""></path>
                                      </svg></svg-icon>
                                  </div>

                                  <div _ngcontent-bbw-c87="" class="text">Print in the ratio of your choice</div>
                                </div>
                              </app-info-box-line>


                            </div>
                          </app-info-box>
                          <app-info-box _ngcontent-bbw-c90="" _nghost-bbw-c86="">
                            <div _ngcontent-bbw-c86="" class="info-box"  id="digital_info">
                              <app-info-box-line _ngcontent-bbw-c90="" _nghost-bbw-c87="">
                                <div _ngcontent-bbw-c87="" class="info-line">
                                  <div _ngcontent-bbw-c87="" class="cursor">
                                    <svg-icon _ngcontent-bbw-c87=""><svg width="11" height="8" viewBox="0 0 11 8"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c87=""
                                        aria-hidden="true">
                                        <path
                                          d="M3.83343 6.34989L9.19543 0.987305L10.0208 1.81214L3.83343 7.99956L0.121094 4.28722L0.945927 3.46239L3.83343 6.34989Z"
                                          fill="black" _ngcontent-bbw-c87=""></path>
                                      </svg></svg-icon>
                                  </div>

                                  <div _ngcontent-bbw-c87="" class="text">Available immediately after purchase</div>
                                </div>
                              </app-info-box-line>
                              <app-info-box-line _ngcontent-bbw-c90="" _nghost-bbw-c87="">
                                <div _ngcontent-bbw-c87="" class="info-line">
                                  <div _ngcontent-bbw-c87="" class="cursor">
                                    <svg-icon _ngcontent-bbw-c87=""><svg width="11" height="8" viewBox="0 0 11 8"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c87=""
                                        aria-hidden="true">
                                        <path
                                          d="M3.83343 6.34989L9.19543 0.987305L10.0208 1.81214L3.83343 7.99956L0.121094 4.28722L0.945927 3.46239L3.83343 6.34989Z"
                                          fill="black" _ngcontent-bbw-c87=""></path>
                                      </svg></svg-icon>
                                  </div>

                                  <div _ngcontent-bbw-c87="" class="text">Print in the size of your choice</div>
                                </div>
                              </app-info-box-line>


                            </div>
                          </app-info-box>
                          <app-info-box _ngcontent-bbw-c90="" _nghost-bbw-c86="">
                            <div _ngcontent-bbw-c86="" class="info-box visible" id="printed_info">
                              <app-info-box-line _ngcontent-bbw-c90="" _nghost-bbw-c87="">
                                <div _ngcontent-bbw-c87="" class="info-line">
                                  <div _ngcontent-bbw-c87="" class="cursor">
                                    <svg-icon _ngcontent-bbw-c87=""><svg width="11" height="8" viewBox="0 0 11 8"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c87=""
                                        aria-hidden="true">
                                        <path
                                          d="M3.83343 6.34989L9.19543 0.987305L10.0208 1.81214L3.83343 7.99956L0.121094 4.28722L0.945927 3.46239L3.83343 6.34989Z"
                                          fill="black" _ngcontent-bbw-c87=""></path>
                                      </svg></svg-icon>
                                  </div>

                                  <div _ngcontent-bbw-c87="" class="text">Printed on museum-quality, thick, matte art
                                    paper of 200gsm</div>
                                </div>
                              </app-info-box-line>
                              <app-info-box-line _ngcontent-bbw-c90="" _nghost-bbw-c87="">
                                <div _ngcontent-bbw-c87="" class="info-line">
                                  <div _ngcontent-bbw-c87="" class="cursor">
                                    <svg-icon _ngcontent-bbw-c87=""><svg width="11" height="8" viewBox="0 0 11 8"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c87=""
                                        aria-hidden="true">
                                        <path
                                          d="M3.83343 6.34989L9.19543 0.987305L10.0208 1.81214L3.83343 7.99956L0.121094 4.28722L0.945927 3.46239L3.83343 6.34989Z"
                                          fill="black" _ngcontent-bbw-c87=""></path>
                                      </svg></svg-icon>
                                  </div>

                                  <div _ngcontent-bbw-c87="" class="text">Responsibly sourced FSC certified paper from
                                    sustainably managed forests</div>
                                </div>
                              </app-info-box-line>


                            </div>
                          </app-info-box>
                          <app-info-box _ngcontent-bbw-c90="" _nghost-bbw-c86="">
                            <div _ngcontent-bbw-c86="" class="info-box" id="streched_info">
                              <app-info-box-line _ngcontent-bbw-c90="" _nghost-bbw-c87="">
                                <div _ngcontent-bbw-c87="" class="info-line">
                                  <div _ngcontent-bbw-c87="" class="cursor">
                                    <svg-icon _ngcontent-bbw-c87=""><svg width="11" height="8" viewBox="0 0 11 8"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c87=""
                                        aria-hidden="true">
                                        <path
                                          d="M3.83343 6.34989L9.19543 0.987305L10.0208 1.81214L3.83343 7.99956L0.121094 4.28722L0.945927 3.46239L3.83343 6.34989Z"
                                          fill="black" _ngcontent-bbw-c87=""></path>
                                      </svg></svg-icon>
                                  </div>

                                  <div _ngcontent-bbw-c87="" class="text">Printed on a strong canvas material (340 gsm)
                                  </div>
                                </div>
                              </app-info-box-line>
                              <app-info-box-line _ngcontent-bbw-c90="" _nghost-bbw-c87="">
                                <div _ngcontent-bbw-c87="" class="info-line">
                                  <div _ngcontent-bbw-c87="" class="cursor">
                                    <svg-icon _ngcontent-bbw-c87=""><svg width="11" height="8" viewBox="0 0 11 8"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c87=""
                                        aria-hidden="true">
                                        <path
                                          d="M3.83343 6.34989L9.19543 0.987305L10.0208 1.81214L3.83343 7.99956L0.121094 4.28722L0.945927 3.46239L3.83343 6.34989Z"
                                          fill="black" _ngcontent-bbw-c87=""></path>
                                      </svg></svg-icon>
                                  </div>

                                  <div _ngcontent-bbw-c87="" class="text">Canvas has a 4 cm (1.6") thick frame.</div>
                                </div>
                              </app-info-box-line>


                            </div>
                          </app-info-box>
                          <app-info-box _ngcontent-bbw-c90="" _nghost-bbw-c86="">
                            <div _ngcontent-bbw-c86="" class="info-box" id="framed_info">
                              <app-info-box-line _ngcontent-bbw-c90="" _nghost-bbw-c87="">
                                <div _ngcontent-bbw-c87="" class="info-line">
                                  <div _ngcontent-bbw-c87="" class="cursor">
                                    <svg-icon _ngcontent-bbw-c87=""><svg width="11" height="8" viewBox="0 0 11 8"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c87=""
                                        aria-hidden="true">
                                        <path
                                          d="M3.83343 6.34989L9.19543 0.987305L10.0208 1.81214L3.83343 7.99956L0.121094 4.28722L0.945927 3.46239L3.83343 6.34989Z"
                                          fill="black" _ngcontent-bbw-c87=""></path>
                                      </svg></svg-icon>
                                  </div>

                                  <div _ngcontent-bbw-c87="" class="text">Printed on museum-quality, thick, matte art
                                    paper of 200gsm</div>
                                </div>
                              </app-info-box-line>
                              <app-info-box-line _ngcontent-bbw-c90="" _nghost-bbw-c87="">
                                <div _ngcontent-bbw-c87="" class="info-line">
                                  <div _ngcontent-bbw-c87="" class="cursor">
                                    <svg-icon _ngcontent-bbw-c87=""><svg width="11" height="8" viewBox="0 0 11 8"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c87=""
                                        aria-hidden="true">
                                        <path
                                          d="M3.83343 6.34989L9.19543 0.987305L10.0208 1.81214L3.83343 7.99956L0.121094 4.28722L0.945927 3.46239L3.83343 6.34989Z"
                                          fill="black" _ngcontent-bbw-c87=""></path>
                                      </svg></svg-icon>
                                  </div>

                                  <div _ngcontent-bbw-c87="" class="text"> Lightweight 1-2 cm (0.4-0.8") thick frame.
                                    Shatterproof, transparent plexiglass.</div>
                                </div>
                              </app-info-box-line>


                            </div>
                          </app-info-box>
                          <app-details-row _ngcontent-bbw-c90="" _nghost-bbw-c81="">
                            <div _ngcontent-bbw-c81="" class="details-row">
                              <div _ngcontent-bbw-c81="" class="label">


                              </div>
                              <div _ngcontent-bbw-c81="" class="form-element">
                                <app-text-header _ngcontent-bbw-c90="" label="format.orientation" _nghost-bbw-c84="">
                                  <div _ngcontent-bbw-c84="" class="section-title">
                                    <span _ngcontent-bbw-c84="">Orientation</span>
                                  </div>
                                </app-text-header>
                              </div>
                            </div>
                          </app-details-row>

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-4 style-mobile-grid-4 style-grid app-grid-orientation">
                              <app-style-selector _ngcontent-bbw-c90="" _nghost-bbw-c88="">
                                <div _ngcontent-bbw-c88="" class="style-selector">
                                  <div _ngcontent-bbw-c88="" class="selector active" data-orientation="portrait">
                                    <div _ngcontent-bbw-c88="" class="content">
                                      <svg-icon _ngcontent-bbw-c90=""><svg width="48" height="48" viewBox="0 0 48 48"
                                          fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c90=""
                                          aria-hidden="true">
                                          <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M37.5 42.5V5.5H36.25H36H12H10.5V42.5H37.5ZM39 42.5V44H37.5H10.5H9V42.5V5.5V4H10.5H12H36H36.25H37.5H39V5.5V42.5ZM26.2536 18.4821L26.9029 19.631L33.4029 31.131C33.6067 31.4916 33.4796 31.9491 33.119 32.1529C32.7584 32.3567 32.3009 32.2296 32.0971 31.869L26.2464 21.5179L22.9012 27.3721L22.2788 28.4612L21.614 27.3975L19.7694 24.4462L15.3965 31.8803C15.1864 32.2373 14.7268 32.3565 14.3697 32.1465C14.0127 31.9364 13.8935 31.4768 14.1035 31.1197L19.1035 22.6197L19.7306 21.5538L20.386 22.6025L22.2212 25.5388L25.5988 19.6279L26.2536 18.4821ZM31.25 19C32.0784 19 32.75 18.3284 32.75 17.5C32.75 16.6716 32.0784 16 31.25 16C30.4216 16 29.75 16.6716 29.75 17.5C29.75 18.3284 30.4216 19 31.25 19Z"
                                            fill="#16212C" _ngcontent-bbw-c90=""></path>
                                        </svg></svg-icon>
                                    </div>
                                  </div>
                                  <div _ngcontent-bbw-c88="" class="label-area">
                                    <div _ngcontent-bbw-c88="" class="label">portrait</div>

                                  </div>

                                </div>
                              </app-style-selector>


                              <app-style-selector _ngcontent-bbw-c90="" _nghost-bbw-c88="">
                                <div _ngcontent-bbw-c88="" class="style-selector">
                                  <div _ngcontent-bbw-c88="" class="selector" data-orientation="square">
                                    <div _ngcontent-bbw-c88="" class="content">
                                      <svg-icon _ngcontent-bbw-c90=""><svg width="48" height="48" viewBox="0 0 48 48"
                                          fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c90=""
                                          aria-hidden="true">
                                          <g clip-path="url(#clip0_270:1044)" _ngcontent-bbw-c90="">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M10.5 37.5L37.5 37.5V36.25V36L37.5 12V10.5L10.5 10.5L10.5 37.5ZM10.5 39H9V37.5V10.5L9 9H10.5H37.5H39V10.5V12L39 36V36.25V37.5V39H37.5L10.5 39ZM26.2536 18.4821L26.9029 19.6309L33.4029 31.1309C33.6067 31.4915 33.4796 31.9491 33.119 32.1529C32.7584 32.3567 32.3009 32.2296 32.0971 31.869L26.2464 21.5179L22.9012 27.3721L22.2788 28.4612L21.614 27.3975L19.7694 24.4462L15.3965 31.8802C15.1864 32.2373 14.7268 32.3564 14.3697 32.1464C14.0127 31.9364 13.8935 31.4767 14.1036 31.1197L19.1036 22.6197L19.7306 21.5538L20.386 22.6025L22.2212 25.5388L25.5988 19.6279L26.2536 18.4821ZM31.25 19C32.0784 19 32.75 18.3284 32.75 17.5C32.75 16.6716 32.0784 16 31.25 16C30.4216 16 29.75 16.6716 29.75 17.5C29.75 18.3284 30.4216 19 31.25 19Z"
                                              fill="#16212C" _ngcontent-bbw-c90=""></path>
                                          </g>
                                          <defs _ngcontent-bbw-c90="">
                                            <clippath id="clip0_270:1044" _ngcontent-bbw-c90="">
                                              <rect width="48" height="48" fill="white" _ngcontent-bbw-c90=""></rect>
                                            </clippath>
                                          </defs>
                                        </svg></svg-icon>
                                    </div>
                                  </div>
                                  <div _ngcontent-bbw-c88="" class="label-area">
                                    <div _ngcontent-bbw-c88="" class="label">square</div>

                                  </div>

                                </div>
                              </app-style-selector>


                              <app-style-selector _ngcontent-bbw-c90="" _nghost-bbw-c88="">
                                <div _ngcontent-bbw-c88="" class="style-selector">
                                  <div _ngcontent-bbw-c88="" class="selector" data-orientation="landscape">
                                    <div _ngcontent-bbw-c88="" class="content">
                                      <svg-icon _ngcontent-bbw-c90=""><svg width="48" height="48" viewBox="0 0 48 48"
                                          fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c90=""
                                          aria-hidden="true">
                                          <g clip-path="url(#clip0_270:1043)" _ngcontent-bbw-c90="">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M5.5 37.5L42.5 37.5V36.25V36V12V10.5L5.5 10.5L5.5 37.5ZM5.5 39H4V37.5V10.5V9H5.5H42.5L44 9V10.5V12V36V36.25V37.5V39H42.5L5.5 39ZM26.2536 18.4821L26.9029 19.6309L33.4029 31.1309C33.6067 31.4915 33.4796 31.9491 33.119 32.1529C32.7584 32.3567 32.3009 32.2296 32.0971 31.869L26.2464 21.5179L22.9012 27.3721L22.2788 28.4612L21.614 27.3975L19.7694 24.4462L15.3964 31.8802C15.1864 32.2373 14.7268 32.3564 14.3697 32.1464C14.0127 31.9364 13.8935 31.4767 14.1035 31.1197L19.1035 22.6197L19.7306 21.5538L20.386 22.6025L22.2212 25.5388L25.5988 19.6279L26.2536 18.4821ZM31.25 19C32.0784 19 32.75 18.3284 32.75 17.5C32.75 16.6716 32.0784 16 31.25 16C30.4216 16 29.75 16.6716 29.75 17.5C29.75 18.3284 30.4216 19 31.25 19Z"
                                              fill="#16212C" _ngcontent-bbw-c90=""></path>
                                          </g>
                                          <defs _ngcontent-bbw-c90="">
                                            <clippath id="clip0_270:1043" _ngcontent-bbw-c90="">
                                              <rect width="48" height="48" fill="white" _ngcontent-bbw-c90=""></rect>
                                            </clippath>
                                          </defs>
                                        </svg></svg-icon>
                                    </div>
                                  </div>
                                  <div _ngcontent-bbw-c88="" class="label-area">
                                    <div _ngcontent-bbw-c88="" class="label">landscape</div>

                                  </div>

                                </div>
                              </app-style-selector>



                            </div>
                          </app-style-grid>

                          <app-details-row _ngcontent-bbw-c90="" _nghost-bbw-c81="">
                            <div _ngcontent-bbw-c81="" class="details-row">
                              <div _ngcontent-bbw-c81="" class="label">


                              </div>
                              <div _ngcontent-bbw-c81="" class="form-element">
                                <app-text-header _ngcontent-bbw-c90="" label="format.format" _nghost-bbw-c84="">
                                  <div _ngcontent-bbw-c84="" class="section-title">
                                    <span _ngcontent-bbw-c84="">Size</span>
                                  </div>
                                </app-text-header>
                              </div>
                            </div>
                          </app-details-row>

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder printed_portrait_prices za-price-box-visible" id="printed_portrait_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">30 x 40 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">49.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">50 x 70 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">69.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Large</div>
                                      <div _ngcontent-bbw-c89="" class="size">70 x 100 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">85.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder printed_square_prices" id="printed_square_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">30 x 30 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">44.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">50 x 50 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">59.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder printed_landscape_prices" id="printed_landscape_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">40 x 30 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">49.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">70 x 50 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">69.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Large</div>
                                      <div _ngcontent-bbw-c89="" class="size">100 x 70 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">85.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder framed_portrait_prices" id="framed_portrait_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">30 x 40 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">105.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">50 x 70 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">139.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder framed_square_prices" id="framed_square_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">30 x 30 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">105.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">50 x 50 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">129.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>                          

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder framed_landscape_prices" id="framed_landscape_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">40 x 30 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">105.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">70 x 50 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">139.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder streched_portrait_prices" id="streched_portrait_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">30 x 40 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">84.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">50 x 70 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">129.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder streched_square_prices" id="streched_square_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">30 x 40 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">84.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">50 x 50 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">129.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>                          

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder streched_landscape_prices" id="streched_landscape_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">40 x 30 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">84.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">70 x 50 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">129.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder digital_portrait_prices" id="digital_portrait_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">30 x 40 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">28.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">40 x 50 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">28.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Large</div>
                                      <div _ngcontent-bbw-c89="" class="size">50 x 60 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">28.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder digital_square_prices" id="digital_square_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">30 x 30 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">28.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">50 x 50 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">28.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>                          

                          <app-style-grid _ngcontent-bbw-c90="" _nghost-bbw-c85="">
                            <div _ngcontent-bbw-c85="" class="style-desktop-grid-5 style-mobile-grid-4 style-just-wrap price-boxes-holder digital_landscape_prices" id="digital_landscape_prices">
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector active">
                                      <div _ngcontent-bbw-c89="" class="header">Small</div>
                                      <div _ngcontent-bbw-c89="" class="size">40 x 30 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">28.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Medium</div>
                                      <div _ngcontent-bbw-c89="" class="size">50 x 40 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">28.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                              <div _ngcontent-bbw-c90="" class="format-column">
                                <app-price-presenter _ngcontent-bbw-c90="" _nghost-bbw-c89="">
                                  <div _ngcontent-bbw-c89="" class="price-selector">
                                    <div _ngcontent-bbw-c89="" class="selector">
                                      <div _ngcontent-bbw-c89="" class="header">Large</div>
                                      <div _ngcontent-bbw-c89="" class="size">90 x 60 cm</div>
                                      <div _ngcontent-bbw-c89="" class="price"><span class="za-price">28.00</span> $</div>
                                    </div>
                                  </div>
                                </app-price-presenter>
                              </div>
                            </div>
                          </app-style-grid>

                          
                        </app-new-format>
                      </div>
                    </app-tab-content-wrapper>
                  </app-maps-format>
                </div>

                <app-add-to-cart _ngcontent-bbw-c195="" _nghost-bbw-c194="" style="height: 144px;">
                  <div _ngcontent-bbw-c194="" style="max-width: 445px;" class="">
                    <app-tab-content-wrapper _ngcontent-bbw-c194="" _nghost-bbw-c185="">
                      <div _ngcontent-bbw-c185="" class="content-wrapper">
                        <div _ngcontent-bbw-c194="" class="add-to-cart-area">
                          <div _ngcontent-bbw-c194="" class="info-action-area">
                            <app-price-indicator _ngcontent-bbw-c194="" _nghost-bbw-c192="">
                              <div _ngcontent-bbw-c192="" class="price-indicator">
                                <div _ngcontent-bbw-c192="" class="price-tag">Price</div>
                                <div _ngcontent-bbw-c192="" class="price-value">
                                  <div _ngcontent-bbw-c192="" class="price-inner">
                                    <div _ngcontent-bbw-c192="" class="price"><span id="za_product_price">49.00</span> $</div>
                                    <div _ngcontent-bbw-c192="" class="vat">includes 0.00 $ VAT</div>

                                  </div>
                                </div>
                              </div>
                            </app-price-indicator>
                            <app-save-favorite _ngcontent-bbw-c194="" _nghost-bbw-c193="">
                              <div _ngcontent-bbw-c193="" class="save-favorite">
                                <div _ngcontent-bbw-c193="" class="favorite-box">
                                  <div _ngcontent-bbw-c193="" class="favorite-icon">
                                    <svg-icon _ngcontent-bbw-c193=""><svg width="28" height="25" viewBox="0 0 28 25"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c193=""
                                        aria-hidden="true">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M25.2963 2.75113C22.5274 -0.0497512 17.9891 -0.0498572 15.2201 2.75082L15.2198 2.75113L13.8548 4.12948L12.4922 2.75113C9.72328 -0.0498571 5.18468 -0.0498571 2.41573 2.75113C-0.34691 5.54574 -0.34691 10.1169 2.41573 12.9115L13.1448 23.7647C13.2448 23.8658 13.3609 23.9411 13.485 23.9906C13.7606 24.1005 14.0749 24.0829 14.3377 23.9383C14.4202 23.893 14.4976 23.8351 14.5672 23.7647L25.2963 12.9115C28.0589 10.1169 28.0589 5.54574 25.2963 2.75113ZM13.856 21.6393L23.874 11.5054C25.8664 9.48998 25.8664 6.17265 23.874 4.15719C21.8879 2.14812 18.6282 2.14812 16.6421 4.15719L16.6415 4.15781L14.7884 6.02908C14.7404 6.12684 14.6754 6.21835 14.5936 6.29924C14.5171 6.37487 14.4315 6.43563 14.3403 6.48154L11.6876 9.16027C11.299 9.5527 10.6658 9.55578 10.2734 9.16717C9.88098 8.77855 9.87789 8.1454 10.2665 7.75297L12.4474 5.55066L11.0699 4.15719C9.08382 2.14812 5.82414 2.14812 3.83805 4.15719C1.84565 6.17265 1.84565 9.48998 3.83805 11.5054L13.856 21.6393Z"
                                          fill="#828282" _ngcontent-bbw-c193=""></path>
                                      </svg></svg-icon>
                                  </div>

                                </div>
                              </div>
                            </app-save-favorite>

                          </div>
                          <div _ngcontent-bbw-c194="" class="button-area">
                            <div _ngcontent-bbw-c194="" class="button">
                              <app-button _ngcontent-bbw-c194="" _nghost-bbw-c93="">
                                <div _ngcontent-bbw-c93="" class="button-component-wrapper">


                                  <div _ngcontent-bbw-c93="" class="button main zme-add-to-cart" style="opacity: 1;">Add to cart
                                    <svg-icon _ngcontent-bbw-c93=""><svg width="8" height="14" viewBox="0 0 8 14"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" _ngcontent-bbw-c93=""
                                        aria-hidden="true">
                                        <path
                                          d="M5.172 7.00026L0.222001 2.05026L1.636 0.636257L8 7.00026L1.636 13.3643L0.222 11.9503L5.172 7.00026Z"
                                          fill="#16212C" _ngcontent-bbw-c93=""></path>
                                      </svg></svg-icon>




                                  </div>
                                </div>
                              </app-button>
                            </div>
                            <div _ngcontent-bbw-c194="" class="favorite">

                            </div>
                          </div>
                        </div>
                      </div>
                    </app-tab-content-wrapper>
                  </div>
                </app-add-to-cart>





              </div>
              <div _ngcontent-bbw-c75="" class="right-section">
                <div _ngcontent-bbw-c75="" class="prevent-overflow-poster-around">
                  <div _ngcontent-bbw-c195="" preview="">
                    <app-maps-poster _ngcontent-bbw-c195="" _nghost-bbw-c180="">
                      <div _ngcontent-bbw-c180="" class="poster-container">
                        <div _ngcontent-bbw-c180="" class="poster">
                          <app-poster-preview-switcher _ngcontent-bbw-c180="" _nghost-bbw-c178="">
                            <div _ngcontent-bbw-c178="" class="poster-preview-switcher">
                              <div _ngcontent-bbw-c178="" class="preview-area">
                                <div _ngcontent-bbw-c178="" class="header">Project preview</div>
                                
                              </div>
                              <div _ngcontent-bbw-c180="" class="info-over-preview interactivity-info"> The map is fully
                                interactive. Go ahead - zoom, drag, and play with it!



                              </div>
                              <div class="map-area">
                                <div class="za-map-panel">
                                  <div class="za-map-wrap" id="zaCustomMap">
                                    <div class="za-map-setting">
                                      <div id="map-canvas"></div>
                                    </div>
                                    <div class="za-map-details">
                                      <h2 class="za-map-title">Qinghai, China</h2>
                                      <h4 class="za-map-coordinates">25.76168°N / 100.19179°W</h4>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div _ngcontent-bbw-c180="" class="info-over-preview credentials-info"> ©️ OpenMapTiles ©️
                                OpenStreetMap contributor </div>
                            </div>
                          </app-poster-preview-switcher>
                        </div>
                      </div>
                    </app-maps-poster>


                  </div>

                </div>
              </div>

            </div>
          </app-container>
        </div>


      </app-poster-layout>


    </app-maps-editor>



</app-root>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="'.plugin_dir_url( __FILE__ ) .'js/main.js"></script>
    <script src="'.plugin_dir_url( __FILE__ ) .'js/html2canvas.js"></script>';
 
 return $output;
}