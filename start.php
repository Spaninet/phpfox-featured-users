<?php

namespace Core;

if (!Is::app('PHPfox_FeaturedUsers')) {
	return false;
}

new Payment\Event('featured-users', function(\Core\Payment\Object $payment) {
	$payment->log('Event touchdown...');

	if ($payment->success()) {
		$payment->log('Setting user "' . $payment->item_number . '" to be featured.');

		$db = new Db();
		$cache = new Cache();

		try {
			$user = (new \Api\User())->get($payment->item_number);

			$total = (int) ($db->select('*')->from(':user_featured')->count());
			$total++;

			$db->delete(':user_featured', ['user_id' => $user->id]);
			$db->insert(':user_featured', ['user_id' => $user->id, 'ordering' => $total]);

			$cache->del('featured_users');
		} catch (\Exception $e) {
			$payment->log($e->getMessage());
		}
	}

});

new Route('/featured-users/thanks', function(Controller $controller) {

	return $controller->render('thanks.html');
});

new Route('/featured-users/pay', function(Controller $controller) {
	$auth = new Auth\User();
	$auth->membersOnly();

	$controller->h1(_p('Get Featured'), '');

	return $controller->render('pay.html');
});