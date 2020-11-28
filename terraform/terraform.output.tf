# ====================
#
# Output
#
# ====================
# apply後にElastic IPのパブリックIPを出力する
output "public_ip" {
  value = aws_eip.example.public_ip
}