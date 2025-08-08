<?php

// Standalone encryption tool for Postman testing

// Bootstrap the necessary Yii2 files
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/common/config/bootstrap.php';
require __DIR__ . '/frontend/config/bootstrap.php';

// Manually include your component if it's not autoloaded properly
require __DIR__ . '/common/components/AesCrypto.php';

// --- CONFIGURE YOUR TEST DATA HERE ---

$json = "{\"api_para\":{\"userId\":\"99985561\",\"fromType\":\"number\",\"from\":\"9650901148\",\"toType\":\"number\",\"to\":\"9315723354\",\"reqId\":\"rIhwk_1754661511_W_jMI\"},\"contactListData\":{},\"did\":null,\"cType\":\"CTC\",\"campId\":0,\"excAdm\":75,\"ivrSTime\":\"2025-08-08 19:28:32\",\"ivrETime\":\"2025-08-08 19:28:51\",\"ivrDuration\":19,\"userId\":\"99985561\",\"cNumber\":\"919315723354\",\"masterNumCTC\":\"919650901148\",\"masterAgent\":\"\",\"masterAgentNumber\":\"\",\"masterGroupId\":0,\"talkDuration\":8,\"agentOnCallDuration\":0,\"callId\":\"2me2nb2r2175466151149712937\",\"firstAttended\":\"from\",\"firstAnswerTime\":\"2025-08-08 19:28:35\",\"lastHangupTime\":\"2025-08-08 19:28:51\",\"lastFirstDuration\":16,\"custAnswerSTime\":\"2025-08-08 19:28:43\",\"custAnswerETime\":\"2025-08-08 19:28:51\",\"custAnswerDuration\":48,\"callStatus\":3,\"ivrExecuteFlow\":null,\"HangupBySourceDetected\":0,\"forward\":\"false\",\"totalHoldDuration\":0,\"totalCreditsUsed\":{\"freeHit\":2,\"paidHit\":0,\"amount\":0},\"ivrIdArr\":[],\"aAnsH\":[],\"aH\":[],\"nH\":[\"919315723354\",\"919650901148\"],\"recordings\":[{\"nodeid\":\"to\",\"visitId\":\"1754661514686\",\"file\":\"/202508/2me2nb2r2175466151149712937_9315723354_2025-8-8-19-28-43_CTC.mp3\",\"time\":\"2025-08-08 19:28:43\"}],\"voiceMail\":[],\"DTMF\":[],\"cliArr\":{\"9650901148\":[\"917557180901\"],\"9315723354\":[\"917557180901\"]},\"aHDetail\":[],\"nHDetail\":[{\"CTC\":\"to\",\"status\":\"answered\",\"recording\":\"/202508/2me2nb2r2175466151149712937_9315723354_2025-8-8-19-28-43_CTC.mp3\",\"ping\":\"direct\",\"number\":\"919315723354\",\"visitId\":\"1754661514686\",\"nodeId\":\"#1\",\"totalRingDuration\":8,\"totalHoldDuration\":0,\"talkDuration\":8,\"talkSTime\":\"2025-08-08 19:28:43\",\"talkETime\":\"2025-08-08 19:28:51\",\"answerSTime\":\"2025-08-08 19:28:43\",\"answerETime\":\"2025-08-08 19:28:51\",\"answerDuration\":8,\"cli\":\"917557180901\",\"retry\":0,\"recordingUrl\":\"https://s-ct3.sarv.com/v2/recording/direct/99985561/202508/2me2nb2r2175466151149712937_9315723354_2025-8-8-19-28-43_CTC.mp3\"},{\"CTC\":\"from\",\"status\":\"answered\",\"recording\":\"/202508/2me2nb2r2175466151149712937_9315723354_2025-8-8-19-28-43_CTC.mp3\",\"ping\":\"direct\",\"number\":\"919650901148\",\"visitId\":\"1754661511518\",\"nodeId\":\"#1\",\"totalRingDuration\":3,\"totalHoldDuration\":0,\"talkDuration\":8,\"talkSTime\":\"2025-08-08 19:28:43\",\"talkETime\":\"2025-08-08 19:28:51\",\"answerSTime\":\"2025-08-08 19:28:35\",\"answerETime\":\"2025-08-08 19:28:51\",\"answerDuration\":16,\"cli\":\"917557180901\",\"retry\":0,\"recordingUrl\":\"https://s-ct3.sarv.com/v2/recording/direct/99985561/202508/2me2nb2r2175466151149712937_9315723354_2025-8-8-19-28-43_CTC.mp3\"}],\"modules\":[],\"callDisposition\":\"[]\",\"callBack\":\"\"}";
$arr = json_decode($json, true);
print_r($arr);