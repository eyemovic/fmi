                      <?php
                        $seminar_query = new WP_Query( $args );
                        if($seminar_query->have_posts()): while ($seminar_query->have_posts()): $seminar_post = $seminar_query->the_post();
                          $seminar_post_date_start = get_field('seminar_date_start', $seminar_post->ID);
                          $seminar_post_date_end = get_field('seminar_date_end', $seminar_post->ID);
                          $seminar_post_status = get_field('seminar_status', $seminar_post->ID);
                          switch($seminar_post_status->slug){
                            case 'now':
                              $seminar_post_status_class = ' is-open'; break;
                            case 'few':
                              $seminar_post_status_class = ' is-few'; break;
                            case 'full':
                              $seminar_post_status_class = ' is-closed'; break;
                            case 'finished':
                              $seminar_post_status_class = ' is-disabled'; break;
                          }
                          $week = ['日','月','火','水','木','金','土'];
                      ?>
                      <li>
                        <a href="<?php the_permalink(); ?>" class="semina-calender-status<?php echo $seminar_post_status_class; ?>">
                          <span class="calender-date"><?php echo date_i18n('j日', strtotime($seminar_post_date_start)); ?>（<?php echo $week[date_i18n('w', strtotime($seminar_post_date_start))]; ?>）</span>
                          <span class="calender-label"><?php echo $seminar_post_status->name; ?><span class="calender-compare" style="display:none;"><?php echo date_i18n('Y:m:d:H:i:s',strtotime($seminar_post_date_start)); ?><?php echo date_i18n('Y:m:d:H:i:s',strtotime($seminar_post_date_end)); ?></span></span>
                        </a>
                      </li>
                      <?php endwhile; endif; wp_reset_query(); ?>