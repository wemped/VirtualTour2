package com.example.wemped.virtualtourskeleton;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTabHost;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

/*Our TabHost, creates a tab for each map.*/

public class TabHostFragment extends Fragment{
    private FragmentTabHost tabHost;
    private Map[] maps = null;

    public TabHostFragment(Map[] maps){
        this.maps = maps;
    }

    public TabHostFragment(){
        this.maps = Globals.getMaps();
    }

    @Override
    public View onCreateView(LayoutInflater inflater,ViewGroup container,Bundle savedInstanceState){

        tabHost = new FragmentTabHost(getActivity());
        tabHost.setup(getActivity(),getChildFragmentManager(),R.id.frag_tab_host);

        int length = this.maps.length;
        for (int i=0;i<length;i++){
            /*Pass data to the tab by adding it to this bundle*/
            Bundle tabBundle = new Bundle();
            tabBundle.putString("TAB_ITEM_NAME", this.maps[i].getMapDescription());
            tabHost.addTab(tabHost.newTabSpec(this.maps[i].getMapDescription()).setIndicator(this.maps[i].getMapDescription()),TabFragment.class,tabBundle);
        }
        tabHost.setCurrentTab(0);
        return tabHost;
    }

    @Override
    public void onDestroyView(){
        super.onDestroyView();
        tabHost = null;
    }
}
