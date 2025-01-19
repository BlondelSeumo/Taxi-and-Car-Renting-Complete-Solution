import 'dart:convert';

MsgOtpModel msgOtpModelFromJson(String str) => MsgOtpModel.fromJson(json.decode(str));

String msgOtpModelToJson(MsgOtpModel data) => json.encode(data.toJson());

class MsgOtpModel {
  String? responseCode;
  String? result;
  String? responseMsg;
  int? otp;

  MsgOtpModel({
    this.responseCode,
    this.result,
    this.responseMsg,
    this.otp,
  });

  factory MsgOtpModel.fromJson(Map<String, dynamic> json) => MsgOtpModel(
    responseCode: json["ResponseCode"],
    result: json["Result"],
    responseMsg: json["ResponseMsg"],
    otp: json["otp"],
  );

  Map<String, dynamic> toJson() => {
    "ResponseCode": responseCode,
    "Result": result,
    "ResponseMsg": responseMsg,
    "otp": otp,
  };
}
