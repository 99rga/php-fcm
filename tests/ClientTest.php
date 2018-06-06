<?php

namespace g9rga\phpFcm\tests;

use g9rga\phpFcm\src\Client;
use g9rga\phpFcm\src\Notification\AndroidNotification;
use g9rga\phpFcm\src\Target\TokenTarget;
use Google\Auth\Credentials\ServiceAccountJwtAccessCredentials;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testIndex()
    {
        $key = '{
  "type": "service_account",
  "project_id": "churchme-7df24",
  "private_key_id": "4a0672cf5816f056f1be8220bce5ed0d817adcab",
  "private_key": "-----BEGIN PRIVATE KEY-----\nMIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDWkpHgeWqhDTdZ\nJWoLlD2u7N3dX58uz2hly1XtvOTQ7aqbCC2MMY3lgsjK4kP/EYD4G+BHslW8zqX8\nKntVELhHvfiwWjJlwcFniDqSHOa0U5JMgs4Ynz+UlneoQN8V3ZvII/I9hpqGtlHu\nEtJAGElNd/VDqhmXQkIe3Yj2dyTAUWz9Yvhj2b9Jl+9nHMxTuOIEpVsVUF3FuF4D\nNU+pgNQrWRS8wB5w1TaQNsN6r9FHqn3drzmgJVwZxtDKB5x/rhysbvSSPEG6+Tfs\ny5EKg++cYnqU4XmXzZ/VyDVgW+Jt2wi8MnAbL7xuxradyGFxhFbMnwlzCp5EniFH\nG80r/WD/AgMBAAECggEABO/RcKF8+hko0okFEPlJ3H040KTFzUeagtbn4614JGrC\nNpLtv4B0/VEki2BK30jfCzjI+BN6yEkkkg0njUaP0e4gi2zxrqrmGGlnXR4q9P6O\nA02PweNrx9aiudc2txKJIVSf7qNhGnnkn8DdkOYbr8zCS2Rnk91XKuFmRhVp1CEK\ng2lSxYFveOk8aw1RmEgxHyeEU3PtXaDA3Zoi3XloXmRiaCb5lZm6UObyjD42TzPm\nwUupS1lsTyvN980kl6TVWJmTZAneCm8KG9ecGny0ZRDkK56ptvPBQa99LaKx4tmW\npzFTNXqCgPlQ2i/dp3C2pW4z3SV4Cv9533yLzK2wYQKBgQD4gJU5+p+XxOinWufZ\n6nvSuTeY2hpAkm/PpPujc1HhguEKLIjYNf+UeImmSmMPKnmKqh4hVqoV1StgnKj0\nSrP4hh36DfX4W+JmaAejKs1w90W24jvIKC8sjX8cgzyTv5rLjURO0+Z/Cv8UzMSt\nt08UXfn4HHoOGTySBLrIh+8iqQKBgQDdC+pkaxKZhknQwxBZBm/9dhrCiWxbQhK3\nwoMKzid6aRQ01qlU99l8qQ2q8pSSfhYAZc2Dpo4c0cqZl30ZHqnxLoSlJPV1Ymfh\naA4lDGxfrgKDWz1TtIjdtgTN0ERLumGgR536gshQx6qXHQgd/vilnFdFsDDDSPO1\naeEZpGdXZwKBgQDUDj3JVSIdC+4Q6dURszPo1R8pc2yVj6CUS9BkYYMM8neBDBHW\nlvW7R8UGv1Ga3n8LIjJF9sN7kAXNEsJmfNzpBeHMwV8ViatAAiQKS/s2G/xEnPew\nzQG8fh5rQV5PImFAtBMHRXHbFZIouLhZGSUFV1B5Niu9njF+1URi3QTmyQKBgQC5\n/TeobKtGwEZFwIt1zMPYKVLU0tp4YrzrH2AxbEqtZdLZrrDlzHGTwY69gsTeCfcr\nOH1Ww4KZ3y+wUlWxGCr3wyNa7SEXNsifUXVtWOmrC/gTXGbaknIC0w9xuUZtzZIt\nUXUsfnRb+9Set4/H5WyDtGt+OISfHDfrMf50G+/UCwKBgQCiHXBrF2cTr1vXOgsB\nYpdwg5O8jlsc2uJU91ggDazPcpiVO2g+hJcLvpNj6S0eXLIDu4VWT2GyQlRo8/wo\nToieMidmB1/LBZom5B8H0C5WFKJp2GGPsSu4Zc3vcb4Ejrt4fr4Ijxr9ZWblQt3u\nzTlSr/Yq8fAam70kGRXBXYHg6A==\n-----END PRIVATE KEY-----\n",
  "client_email": "firebase-adminsdk-yzvog@churchme-7df24.iam.gserviceaccount.com",
  "client_id": "100041068045123278562",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://accounts.google.com/o/oauth2/token",
  "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-yzvog%40churchme-7df24.iam.gserviceaccount.com"
}
';
//        array(4) {
//        ["access_token"]=>
//  string(130) "ya29.c.ElrQBSfLuq_U9Wh9MJDO_y0zU0knF4TrkpkDQpvqOaOf_CHXdT-sUp0RnqSgcIPnI8J_FEEN8B_BYEOdoZTN67zXeLQfkhblMdHGnhFgMC9PDY_DZ3W2tM9ZliY"
//        ["token_type"]=>
//  string(6) "Bearer"
//        ["expires_in"]=>
//  int(3600)
//  ["created"]=>
//  int(1528139503)
//}
//        $data = json_decode($key, true);
//        $client = new \Google_Client();
//        $client->setAuthConfig([
//            'type' => $data['type'],
//            'client_id' => $data['client_id'],
//            'client_email' => $data['client_email'],
//            'private_key' => $data['private_key'],
//        ]);
//        $client->setScopes([
//            'https://www.googleapis.com/auth/firebase.messaging'
//        ]);
//        var_dump($client->fetchAccessTokenWithAssertion());
//        die;
//        die;
//        53 |      58 | 2018-05-07 19:00:06 | cf2a3b6d0d14850a4ff7dcb62a8d6d6c | dyKjGURjR7g:APA91bHAeU1yqn6U-BoTaGeMHQqipLbTkArdGi3M1dCJoXmzLKjDjGCpxblkaUc-vF3GtgWmiUiM5O7xqdajbJI9gNghblFXbFfouzV0_p-7p3nKK1kku0-IeUMrQe5hgJBH5kbs75bj | android | 1.2.1   |
//        Client error: `POST https://fcm.googleapis.com/v1/projects/churchme-7df24/messages:send` resulted in a `401 Unauthorized` response:
//{
//    "error": {
//    "code": 401,
//    "message": "Request had invalid authentication credentials. Expected OAuth 2 access  (truncated...)
//array(1) {
//  [0]=>
//  string(137) "Bearer ya29.c.ElrQBSfLuq_U9Wh9MJDO_y0zU0knF4TrkpkDQpvqOaOf_CHXdT-sUp0RnqSgcIPnI8J_FEEN8B_BYEOdoZTN67zXeLQfkhblMdHGnhFgMC9PDY_DZ3W2tM9ZliY"
//}
        $client = new Client('ya29.c.ElrRBV1UrnT7XXJsrxmKsAXKMXkcyRMyEgrYl6VD7fARiMfSMGja-LzQ4EBTQi_T4dAokNKHBa6w9nanjcIGl-KEcLt9kPg7PXqtBCkE21XaBu7prFsS2LDvG-4', 'churchme-7df24');
        $target = new TokenTarget('dyKjGURjR7g:APA91bHAeU1yqn6U-BoTaGeMHQqipLbTkArdGi3M1dCJoXmzLKjDjGCpxblkaUc-vF3GtgWmiUiM5O7xqdajbJI9gNghblFXbFfouzV0_p-7p3nKK1kku0-IeUMrQe5hgJBH5kbs75bj');
//        $target = new TokenTarget('cBkGz2FVn9U:APA91bGljVfD2YX_Q5tsxbiPVX4sODnsgmf-LbBzC3I9wTJDl9TtLvL66PSFKGkEsT-hWSGYm469soo1zotcCBNwwDjSaN2bSDK1jvt9BF453Q_SFCz0ktyjzCku6bil_zqJn_VQvaOC');
        $androidNotification = new AndroidNotification();
        $androidNotification->setTitle('test title');
        $androidNotification->setBody('sss');
        $androidNotification->setIcon('notification_icon');
        try {
        $response = $client->send($target, $androidNotification);
        $result = ($response->getBody()->getContents());
        var_dump($result);die;
        die;
        } catch (RequestException $e) {
            echo $e->getMessage();
            var_dump($e->getRequest()->getHeader('Authorization'));die;
        }
    }
}
