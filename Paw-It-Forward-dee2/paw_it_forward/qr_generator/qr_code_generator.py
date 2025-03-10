import qrcode
import os

# generated QR Codes are saved in the "qr-gnerated-code" folder
script_dir = os.path.dirname(os.path.abspath(__file__))  
save_path = os.path.join(script_dir, "qr_generated-code")  
os.makedirs(save_path, exist_ok=True)  

"""
### i listed actual GCash numbers here -- dee
- Dog 1 (Name: Cinnamon) from Stray Matters (Contact: 09155579625) -- https://www.facebook.com/share/p/1FexzTu6D2/
- Dog 2 (Name: Cookie) from TAARA—Bicolandia’s Voice for the Voiceless (Contact: 09055238105) -- https://www.facebook.com/share/p/15FprVanrr/
- Dog 3 (Name: Oreo) from Stray Matters (Contact: 09155579625) -- https://www.facebook.com/share/p/18KJCWVmF1/
- Dog 4 (Name: Sandy) from TAARA—Bicolandia’s Voice for the Voiceless (Contact: 09166437535) -- https://www.facebook.com/share/p/15FprVanrr/
- Dog 5 (Name: Mocha) from Stray Matters (Contact: 09155579625)(Contact: 09166437535) -- https://www.facebook.com/share/p/1ULiV58U5G/
- Dog 6 (Name: Spring) from TAARA—Bicolandia’s Voice for the Voiceless (Contact: 09166437535) -- https://www.facebook.com/share/p/1F9CdYd2D8/

NOTE: Please add more if possible...
"""

# Manually input the Facebook post link for each dog (that contains gcash and other contact numbers)
fb_post_link = "https://www.facebook.com/share/p/1F9CdYd2D8/"
# generate QR Code
qr = qrcode.make(fb_post_link)

# save QR Code in the same folder as the script (change the name according to the dog)
file_path = os.path.join(save_path, "gcash_qr_spring.png")
qr.save(file_path)

print(f"QR Code saved at: {file_path}")