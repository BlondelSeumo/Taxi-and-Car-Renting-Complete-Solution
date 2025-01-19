import 'dart:convert';

SmsTypeModel smsTypeModelFromJson(String str) => SmsTypeModel.fromJson(json.decode(str));

String smsTypeModelToJson(SmsTypeModel data) => json.encode(data.toJson());

class SmsTypeModel {
  String? responseCode;
  String? result;
  String? responseMsg;
  String? smsType;
  String? otpAuth;

  SmsTypeModel({
    this.responseCode,
    this.result,
    this.responseMsg,
    this.smsType,
    this.otpAuth,
  });

  factory SmsTypeModel.fromJson(Map<String, dynamic> json) => SmsTypeModel(
    responseCode: json["ResponseCode"],
    result: json["Result"],
    responseMsg: json["ResponseMsg"],
    smsType: json["SMS_TYPE"],
    otpAuth: json["otp_auth"],
  );

  Map<String, dynamic> toJson() => {
    "ResponseCode": responseCode,
    "Result": result,
    "ResponseMsg": responseMsg,
    "SMS_TYPE": smsType,
    "otp_auth": otpAuth,
  };
}
