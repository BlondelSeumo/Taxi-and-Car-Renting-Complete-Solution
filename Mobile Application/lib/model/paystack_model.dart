import 'dart:convert';

PayStackModel payStackModelFromJson(String str) => PayStackModel.fromJson(json.decode(str));

String payStackModelToJson(PayStackModel data) => json.encode(data.toJson());

class PayStackModel {
  bool status;
  String message;
  Data data;

  PayStackModel({
    required this.status,
    required this.message,
    required this.data,
  });

  factory PayStackModel.fromJson(Map<String, dynamic> json) => PayStackModel(
    status: json["status"],
    message: json["message"],
    data: Data.fromJson(json["data"]),
  );

  Map<String, dynamic> toJson() => {
    "status": status,
    "message": message,
    "data": data.toJson(),
  };
}

class Data {
  String authorizationUrl;
  String accessCode;
  String reference;

  Data({
    required this.authorizationUrl,
    required this.accessCode,
    required this.reference,
  });

  factory Data.fromJson(Map<String, dynamic> json) => Data(
    authorizationUrl: json["authorization_url"],
    accessCode: json["access_code"],
    reference: json["reference"],
  );

  Map<String, dynamic> toJson() => {
    "authorization_url": authorizationUrl,
    "access_code": accessCode,
    "reference": reference,
  };
}
