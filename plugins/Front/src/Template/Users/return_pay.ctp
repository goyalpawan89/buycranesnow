

<!-- contenido principal -->
<section class="content background">
	<div class="wrap wrap-user_profile">

      <!-- publicidad superuir -->
      <?= $this->element('Front.publicity_directory'); ?>

       </br>

       <section class="user_pay">
       		
			<h1 class="pay_status_title color3 fondo1"><?= $extras['pay_status']; ?>: <?= $data['payment_status']; ?></h1><br>
			
			<div class="side_pay">
				<table class="user_pay_table">
					<tr>
						<th class="fondo3 color1" colspan="2"><?= $extras['transaction']; ?></th>
					</tr>
					
						<?php foreach ($data as $name => $dato) {

						   if($name == 'payment_status' || $name == 'payment_date' || $name == 'payment_gross' || $name == 'mc_currency' || $name == 'txn_id' || $name == 'item_name') { ?>
								
								<tr>
									<td class="user_pay_td_name"><?= $extras[$name]; ?></td>
									<td class="user_pay_td_data"><?= $dato; ?></td>
								</tr>

						<?php } } ?>

				</table>
			</div>

			<div class="side_pay">
				<table class="user_pay_table">
					<tr>
						<th class="fondo3 color1" colspan="2"><?= $extras['user_info']; ?></th>
					</tr>

					<?php foreach ($authUser as $name => $dato) {

						   if($name == 'company_name' || $name == 'company_email' || $name == 'type') { ?>
								
								<tr>
									<td class="user_pay_td_name"><?= $extras[$name]; ?></td>
									<td class="user_pay_td_data"><?= $dato; ?></td>
								</tr>

					<?php } } ?>

					<tr>
						<td class="user_pay_td_name"><?= $extras['item_name']; ?></td>
						<td class="user_pay_td_data"><?= $data['item_name']; ?></td>
					</tr>

					<tr>
						<td class="user_pay_td_name"><?= $extras['date_start_plan']; ?></td>
						<td class="user_pay_td_data"><?= $data['date_start_plan']; ?></td>
					</tr>

					<tr>
						<td class="user_pay_td_name"><?= $extras['date_end_plan']; ?></td>
						<td class="user_pay_td_data"><?= $data['date_end_plan']; ?></td>
					</tr>

				</table>
			</div>




       </section>


    </div>
</section>