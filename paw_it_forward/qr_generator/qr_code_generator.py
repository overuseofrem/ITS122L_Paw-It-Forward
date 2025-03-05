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
- Dog 3 (Name: Sandy) from TAARA—Bicolandia’s Voice for the Voiceless (Contact: 09166437535) -- https://www.facebook.com/share/p/15FprVanrr/

NOTE: Please add more if possible...
"""

# GCash link - change the number here for every dog 
# (doesn't work due to security purposes hahaha)
# hmmm probably generate a QR code referencing the facebook post instead? I'll think later -- dee
gcash_number = "09166437535"
gcash_link = f"https://gcash.app.link/pay?number={gcash_number}"

# generate QR Code
qr = qrcode.make(gcash_link)

# save QR Code in the same folder as the script (change the name according to the dog)
file_path = os.path.join(save_path, "gcash_qr_sandy.png")
qr.save(file_path)

print(f"QR Code saved at: {file_path}")