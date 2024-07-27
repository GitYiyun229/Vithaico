      <div class="interval <?= $active_interval ?>">
          <div class="top_gp">
              <p class="mb-0">
                  <?php echo FSText::_('Tài khoản') ?>
              </p>
              <p class="mb-0 <?= ($user_member->active_account == 0 && $interval <= 0) ? 'hethan' : 'conhan' ?>">
                  <?= ($user_member->active_account == 0 && $interval <= 0) ? 'Hết hạn' : 'Còn hạn' ?>
              </p>
          </div>
          <div class="box-mid_gp">
              <?php
                $fields = [
                    'Ngày tạo' => date('d/m/Y', strtotime($start_time)),
                    'Hết hạn' => date('d/m/Y', strtotime($due_time))
                ];
                foreach ($fields as $label => $value) : ?>
                  <div class="box-grid">
                      <p><?= FSText::_($label) ?></p>
                      <p class="m-0   


                      "><?= $value ?></p>
                  </div>
              <?php endforeach; ?>
          </div>

          <div class="justify-content-center alert_expiration">
              <?php if ($interval  > 0) { ?>
                  <div class="date_due pt-1">
                      <?php echo FSText::_('Hết hạn sau ')  ?>
                      <span>
                          <?php echo  $interval ?>
                      </span>
                      <?php echo FSText::_(' ngày ')  ?>
                  </div>
              <?php } else { ?>
                  <a href="<?php echo FSRoute::_('index.php?module=home&view=home') ?>" class="alert_expiration-2">
                      <?php echo FSText::_('Gia hạn tài khoản ') ?>
                      <?= $arow ?>
                  </a>
              <?php } ?>
          </div>
      </div>