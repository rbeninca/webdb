apt update 
sudo apt install docker docker-compose docker-doc docker-registry docker.io -y
sudo usermod -aG docker $USER
sudo systemctl enable docker
sudo systemctl start docker
sudo apt install dirmngr ca-certificates software-properties-common apt-transport-https -y
curl -fSsL https://packages.microsoft.com/keys/microsoft.asc | sudo gpg --dearmor | sudo tee /usr/share/keyrings/vscode.gpg > /dev/null
echo deb [arch=amd64 signed-by=/usr/share/keyrings/vscode.gpg] https://packages.microsoft.com/repos/vscode stable main | sudo tee /etc/apt/sources.list.d/vscode.list
sudo apt update
sudo apt install code
sudo flatpak remote-add --if-not-exists flathub https://flathub.org/repo/flathub.flatpakrepo
sudo apt install ssh  -y
sudo apt install git -y
sudo apt install python3-pip -y --fix-missing

