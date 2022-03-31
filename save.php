<table id="dtBasicExample" class="table mt-3 table-striped table-bordered table-secondary" width="100%">
                              <thead>
                                  <tr>
                                      <th scope="col" class="th-sm">Название теста</th>
                                      <th scope="col" class="th-sm">Дата прохождения</th>
                                      <th scope="col" class="th-sm">%</th>
                                      <th scope="col" class="th-sm">%</th>
                                  </tr>
                              </thead>
                              <tbody>
                              
                                      <tr class="sidenav-item sidenav-link">
                                      <?php $count = 0; foreach($tests as $test): $count++?>
                                          <td>
                                            
                                            <div class="card card-test" style="width: 14rem;">
                                              <div>
                                                  <img class="test-date-img" src="img/date.png" alt="date.png" style="width:16px">
                                                  <span class="test-date-for-img"><?=$test['date']?></span>
                                              </div>
                                              <a href="test?test=<?=$test['id']?>"><img src="<?=$test['img_link']?>" class="card-img-test"
                                                      alt="..."></a>
                                              <a href="test?test=<?=$test['id']?>" class="test-name-for-img"><?=$test['test_name']?></a>
                                              <div class="test-author-for-img mt-1">
                                                  <img src="../img/author.png" alt="author.png" style="width:12px">
                                                  <span><?=$test['author']?></span>
                                                  <img src="../img/count_passes.png" alt="count_passes.png" style="margin-left: 2%">
                                                  <span><?=$test['count_passes']?></span>
                                              </div>
                                              <div class="card-body">
                                                  <p class="card-text"><?=$test['description']?></p>
                                                  <div class="text-center">
                                                      <a href="test?test=<?=$test['id']?>" class="btn btn-primary btn-test">Пройти
                                                          тест</a>
                                                  </div>
                                              </div>
                                          </div>
                                            
                                          </td>
                                          
                                          <?php if($count % 4 == 0) echo "<tr class='sidenav-item sidenav-link'>";?>
                                          <?php endforeach ?>
                                      </tr>
                                      
                              
                              </tbody>
                          </table>
